<?php
session_start();

if (!isset($_SESSION["employee_id"]) || $_SESSION["role"] !== "admin") {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>管理者メニュー</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="header">
    <strong>安否確認システム</strong>
    <a href="logout.php">ログアウト</a>
</div>

<div class="container">
    <h2>管理者メニュー</h2>

    <div class="menu-grid">
        <a class="menu-card" href="employee_list.php">
            <h3>社員一覧</h3>
            <p>社員の一覧を表示</p>
        </a>

        <a class="menu-card" href="employee_list.php">
            <h3>安否一覧</h3>
            <p>全社員の安否状況を確認</p>
        </a>
    </div>
</div>

</body>
</html>