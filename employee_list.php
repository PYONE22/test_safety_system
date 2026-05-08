<?php
session_start();
require_once "db.php";
 
if (!isset($_SESSION["employee_id"]) || $_SESSION["role"] !== "admin") {
    header("Location: login.php");
    exit;
}
 
$sql = "SELECT e.employee_id, e.name, d.department_name, e.email, e.role
        FROM employees e
        LEFT JOIN departments d ON e.department_id = d.department_id
        ORDER BY e.employee_id";
 
$stmt = $pdo->query($sql);
$employees = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
 
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>社員一覧</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
 
<div class="header">
    <strong>安否確認システム</strong>
    <a href="logout.php">ログアウト</a>
</div>
 
<div class="container">
    <h2>社員一覧</h2>
 
    <table>
        <tr>
            <th>社員ID</th>
            <th>名前</th>
            <th>部署</th>
            <th>メールアドレス</th>
            <th>権限</th>
        </tr>
 
        <?php foreach ($employees as $emp): ?>
            <tr>
                <td><?= htmlspecialchars($emp["employee_id"]) ?></td>
                <td><?= htmlspecialchars($emp["name"]) ?></td>
                <td><?= htmlspecialchars($emp["department_name"]) ?></td>
                <td><?= htmlspecialchars($emp["email"]) ?></td>
                <td><?= htmlspecialchars($emp["role"]) ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>
 
</body>
</html>
 