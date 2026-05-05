<?php
// 【このファイルで学べること】
// 1. GETメソッドで送信されたデータを受け取る方法
// 2. プリペアドステートメントでデータを保存する方法
// 3. トランザクション処理（beginTransaction, commit, rollBack）
// 4. リダイレクトで画面を切り替える方法

// 【このファイルの目的】
// フォームから送信されたデータをデータベースに保存する

// 【require_once 'db.php' とは？】
// db.php というファイルを読み込んで、そのファイルで定義された $pdo を使えるようにします
// これでデータベースに接続できるようになります
require_once 'db.php';

// 【$_GET とは？】
// $_GET は、フォームでGETメソッドで送信されたデータを受け取るための配列（連想配列）です
// 例：フォームで name="name" の入力欄に「山田」と入力したら
//     $_GET['name'] には「山田」という値が入ります
// 
// 【isset() とは？】
// 指定された変数や配列のキーが存在するかどうかを確認する関数です
// $_GET['name'] が存在すれば true、存在しなければ false を返します
// 
// 【Null合体演算子（??）とは？】
// PHP 7.0以降で使える演算子で、左側がnullまたは存在しない場合に右側の値を返します
// isset() と三項演算子を組み合わせた書き方を簡潔にしたものです
// 
// 書き方1：通常のif文
// if (isset($_GET['name'])) {
//     $name = trim($_GET['name']);
// } else {
//     $name = '';
// }
// 
// 書き方2：三項演算子
// $name = isset($_GET['name']) ? trim($_GET['name']) : '';
// 
// 書き方3：Null合体演算子（推奨：PHP 7.0以降）
// $_GET['name'] が存在すれば trim($_GET['name']) を実行し、
// 存在しない場合は '' （空文字列）を返します
$name = trim($_GET['name'] ?? '');

// メールアドレスも同様に処理
$email = trim($_GET['email'] ?? '');

// 【empty() とは？】
// 変数が空（未入力、0、false、nullなど）かどうかを確認する関数です
// 【|| とは？】
// 「または」という意味の論理演算子です
// $name が空「または」$email が空の場合、という条件になります
if (empty($name) || empty($email)) {
    echo "<h2>エラー</h2>";
    echo "<p>名前とメールアドレスの両方を入力してください。</p>";
    echo '<p><a href="create.php">入力画面に戻る</a></p>';
    // 【exit とは？】
    // プログラムの実行をここで停止します。これ以降のコードは実行されません
    exit;
}

try {
    // 【トランザクションとは？】
    // 複数のSQL文を1つの単位として扱い、全て成功したときだけ確定（コミット）する仕組みです
    // 途中でエラーが発生した場合は、全ての変更を取り消し（ロールバック）できます
    // 
    // 【beginTransaction() とは？】
    // トランザクションを開始します。この後のSQL実行は一時的な状態になり、
    // commit() または rollBack() が呼ばれるまで確定しません
    // 
    // 注意：MySQLの環境構築時にautocommit（自動コミット）がOFFに設定されている場合、
    // beginTransaction() と commit() / rollBack() を必ず使う必要があります
    // 
    // 【補足：SELECT文とトランザクション】
    // 通常のSELECT文（データ取得のみ）の場合は、トランザクションは不要です。
    // データ挿入（INSERT）、更新（UPDATE）、削除（DELETE）などを行う場合に使用します。
    // ただし、例外として SELECT ... FOR UPDATE のように行をロックする場合は別です。
    $pdo->beginTransaction();
    
    // 【プリペアドステートメントとは？】
    // SQL文に直接値を埋め込まず、プレースホルダー（:name や :email など）を使って準備する方法です
    // これはSQLインジェクション攻撃を防ぐための重要なセキュリティ対策です
    // 
    // 【なぜ安全か？】
    // 通常の文字列連結だと、悪意のあるコードが注入される可能性があります
    // 例：「DROP TABLE users」など危険なSQLが入り込む可能性
    // プリペアドステートメントなら、値は単なる「データ」として扱われ、SQLとして実行されません
    $stmt = $pdo->prepare("INSERT INTO users (name, email) VALUES (:name, :email)");
    
    // 【方法1：bindValue() を使う方法】
    // プレースホルダー（:name や :email）に実際の値をバインド（結び付ける）します
    // 第1引数：プレースホルダー名（:name や :email）
    // 第2引数：バインドする値（$name や $email）
    // 第3引数：データ型を指定（PDO::PARAM_STR は「文字列」を意味します）
    $stmt->bindValue(':name', $name, PDO::PARAM_STR);
    $stmt->bindValue(':email', $email, PDO::PARAM_STR);
    
    // 【execute() とは？】
    // 準備したSQL文を実際に実行して、データベースにデータを保存します
    $stmt->execute();
    
    // 【方法2：配列を渡す execute() を使う方法（推奨：より簡潔）】
    // execute() に連想配列を渡すと、配列のキーがプレースホルダー名に対応します
    // この方法なら bindValue() を複数回書く必要がなく、コードが簡潔になります
    // $stmt->execute([':name' => $name, ':email' => $email]);
    
    // 【commit() とは？】
    // トランザクション内の全ての変更を確定（コミット）します
    // この時点で実際にデータベースに保存されます
    // エラーが発生した場合は catch ブロックで rollBack() が呼ばれます
    $pdo->commit();
    
    // 【header() とは？】
    // HTTPレスポンスのヘッダー（追加情報）を設定する関数です
    // "Location: index.php" を設定すると、ブラウザは自動的に index.php に移動します
    // これを「リダイレクト」と言います
    // 保存が成功したら、一覧画面（index.php）に自動的に移動します
    header("Location: index.php");
    exit;
    
} catch (PDOException $e) {
    // エラーが発生した場合の処理
    
    // 【rollBack() とは？】
    // トランザクション内の全ての変更を取り消し（ロールバック）します
    // beginTransaction() 以降の変更は全て元に戻り、データベースの状態は変更前と同じになります
    // これにより、途中でエラーが発生してもデータベースの整合性が保たれます
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }
    
    echo "<h2>エラー</h2>";
    
    // 【htmlspecialchars($e->getMessage()) とは？】
    // $e->getMessage() でエラーメッセージを取得
    // htmlspecialchars() でHTMLの特殊文字を安全な文字に変換（XSS攻撃対策）
    echo "<p>データの保存に失敗しました：" . htmlspecialchars($e->getMessage()) . "</p>";
    echo '<p><a href="create.php">入力画面に戻る</a></p>';
}
?>