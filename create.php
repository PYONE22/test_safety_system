<?php
// 【このファイルで学べること】
// 1. HTMLフォームの基本的な作り方
// 2. GETメソッドで送信するフォームの設定

// 【このファイルの目的】
// 新規ユーザー登録用のフォームを表示する
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>新規ユーザー登録</title>
</head>
<body>
    <h1>新規ユーザー登録</h1>
    
    <!-- 
    【HTMLフォームとは？】
    ユーザーが入力したデータをサーバーに送信するためのHTMLの要素です
    
    【method="GET" とは？】
    フォームの送信方法を指定します
    GETメソッド：データがURLに付いて送信される（例：store.php?name=山田&email=test@example.com）
    POSTメソッド：データがURLには表示されず、HTTPリクエストの本文で送信される
    今回はGETを使用していますが、一般的にはパスワードなどの機密情報はPOSTを使います
    
    【action="store.php" とは？】
    フォームを送信したときに、データを受け取る先のファイルを指定します
    今回は store.php というファイルがデータを受け取って処理します
    -->
    <form method="GET" action="store.php">
        <div>
            <label>名前：</label>
            <!-- name="name" で、この入力欄に入力された値を「name」という名前で送信します -->
            <input type="text" name="name" required>
            <!-- required は「必須入力」を意味します。空欄だと送信できません -->
        </div>
        <div>
            <label>メールアドレス：</label>
            <input type="email" name="email" required>
            <!-- type="email" はメールアドレスの形式であることをブラウザに知らせます -->
        </div>
        <div>
            <button type="submit">保存する</button>
            <!-- type="submit" は「送信ボタン」を意味します。クリックするとフォームが送信されます -->
        </div>
    </form>
    
    <p><a href="index.php">一覧へ戻る</a></p>
</body>
</html>