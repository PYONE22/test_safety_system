<?php

session_start();
require_once 'db.php';


try {

    $stmt = $pdo->query("SELECT * FROM safety_reports ORDER BY report_time DESC");

    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $safety_reports = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    // エラーが発生した場合の処理
    die("データの取得に失敗しました：" . htmlspecialchars($e->getMessage()));
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>自分の安否一覧</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <div class="header">
        <strong>安否確認システム</strong>
        <a href="logout.php">ログアウト</a>
    </div>

    <div class="container">
        <h2>自分の安否一覧</h2>

        <p>ログイン中の社員ID：
            <?= htmlspecialchars($_SESSION["employee_id"]) ?>
        </p>

        <a class="btn" href="report.php">新しく報告する</a>

        <table border="1" cellpadding="8">
            <tr>
                <th>報告日時</th>
                <th>状況</th>
                <th>コメント</th>
            </tr>

            <?php if (!empty($safety_reports)): ?>
                <?php foreach ($safety_reports as $report): ?>
                    <tr>    
                        <td><?= htmlspecialchars($report["report_time"]) ?></td>
                        <td><?= htmlspecialchars($report["status"]) ?></td>
                        <td><?= htmlspecialchars($report["comment"]) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="3">データがありません</td>
                </tr>
            <?php endif; ?>
        </table>

    </div>

</body>

</html>