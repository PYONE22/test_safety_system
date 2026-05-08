<?php
session_start();
require_once "db.php";

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    $sql = "SELECT * FROM employees WHERE email = :email";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([":email" => $email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && $password === $user["password"]) {
        $_SESSION["employee_id"] = $user["employee_id"];
        $_SESSION["name"] = $user["name"];
        $_SESSION["role"] = $user["role"];

        if ($user["role"] === "admin") {
            header("Location: admin_menu.php");
        } else {
            header("Location: report.php");
        }
        exit;
    } else {
        $error = "メールアドレスまたはパスワードが違います。";
    }
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>ログイン</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="login-box">
    <h2>安否確認システム</h2>
    <h3>ログイン</h3>

    <?php if ($error): ?>
        <p style="color:red;"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <form method="post">
        <label>メールアドレス</label>
        <input type="email" name="email" required>

        <label>パスワード</label>
        <input type="password" name="password" required>

        <button type="submit">ログイン</button>
    </form>
</div>

</body>
</html>
