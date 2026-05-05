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
    <title>安否報告</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="header">
    <strong>安否確認システム</strong>
    <a href="logout.php">ログアウト</a>
</div>

<div class="container">
    <h2>安否報告</h2>
    <p>現在の状況を選択してください</p>

    <form method="get" action="store.php"><!--ここ変えた-->
        <div class="status-buttons">
            <label>
                <input type="radio" name="status" value="無事" required>
                <h3>無事</h3>
            </label>

            <label>
                <input type="radio" name="status" value="怪我">
                <h3>怪我</h3>
            </label>

            <label>
                <input type="radio" name="status" value="危険">
                <h3>危険</h3>
            </label>
        </div>

        <label>コメント（任意）</label>
        <textarea name="comment" rows="4"></textarea>

        <button type="submit">送信する</button>
    </form>
</div>

</body>
</html> 
