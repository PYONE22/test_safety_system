<?php
// 【このファイルで学べること】
// 1. データベースから全データを取得する方法
// 2. 取得したデータをテーブル形式で表示する方法
// 3. セキュリティ対策としてhtmlspecialcharsで出力する方法

// 【require_once 'db.php' とは？】
// db.php という他のファイルを読み込む（インクルードする）コマンドです
// require_once は「1回だけ読み込む」という意味
// こうすることで、db.php で作った $pdo 変数（データベース接続オブジェクト）を使えます
// 複数のファイルで同じDB接続情報を使い回すための仕組みです
require_once 'db.php';

// 【try-catch文】
// エラーが発生する可能性のある処理を try で囲み、エラー時は catch で処理します
try {
    // 【SQL文の実行】
    // $pdo->query() でSQLを実行します
    // SELECT文で users テーブルから id, name, email を取得
    // ORDER BY id DESC で id の降順（大きい順）に並べ替えます
    // $stmt は「ステートメント」の略で、実行されたSQLの結果を持っています
    $stmt = $pdo->query("SELECT * FROM users ORDER BY id DESC");
    
    // 【fetchAll() とは？】
    // データベースから取得した全データを配列として取り出します
    // PDO::FETCH_ASSOC は「連想配列形式」で取得するオプション
    // 連想配列とは、$user['name'] のように文字列キーで値を取得できる形式です
    // 結果は $users という配列に格納されます
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
} catch (PDOException $e) {
    // エラーが発生した場合の処理
    die("データの取得に失敗しました：" . htmlspecialchars($e->getMessage()));
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>ユーザー一覧</title>
</head>
<body>
    <h1>ユーザー一覧</h1>
    <p><a href="create.php">新規作成へ</a></p>
    
    <?php 
    // 【if文とcount()】
    // count($users) で配列 $users の中身の数を数えます
    // count($users) > 0 は「データが1件以上ある場合」という条件
    // : と endif; を使った代替構文でHTMLの中に自然に組み込めます
    if (count($users) > 0): 
    ?>
        <table border="1" cellpadding="5">
            <tr>
                <th>ID</th>
                <th>名前</th>
                <th>メール</th>
            </tr>
            <?php 
            // 【foreach文とは？】
            // $users 配列の中身を1つずつ取り出して、$user という変数に入れながら繰り返し処理します
            // 例：1回目は $users[0] が $user に、2回目は $users[1] が $user に入ります
            foreach ($users as $user): 
            ?>
                <tr>
                    <td>
                        <?php 
                        // 【echo とは？】
                        // 画面に文字を出力（表示）するコマンドです
                        
                        // 【htmlspecialchars() とは？】
                        // HTMLの特殊文字（< > & など）を安全な文字に変換します
                        // 例：「<script>」を「&lt;script&gt;」に変換
                        // XSS（クロスサイトスクリプティング）攻撃を防ぐための重要かつ必須のセキュリティ対策です
                        // データベースから取得したデータは必ず htmlspecialchars() でエスケープしましょう
                        // ENT_QUOTES はシングルクォート・ダブルクォートもエスケープするオプション
                        // 'UTF-8' は文字コードを指定しています
                        echo htmlspecialchars($user['id'], ENT_QUOTES, 'UTF-8'); 
                        ?>
                    </td>
                    <td><?php echo htmlspecialchars($user['name'], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php echo htmlspecialchars($user['email'], ENT_QUOTES, 'UTF-8'); ?></td>
                </tr>
            <?php 
            // foreach文の終了
            endforeach; 
            ?>
        </table>
    <?php else: ?>
        <p>登録されているユーザーはまだありません。</p>
    <?php 
    // if文の終了
    endif; 
    ?>
</body>
</html>