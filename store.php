<?php

session_start();

require_once 'db.php';


$status = trim($_POST['status'] ?? '');
$comment = trim($_POST['comment'] ?? '');


if (empty($status)) {
    echo "<h2>エラー</h2>";
    echo "<p>状況を選択してください。</p>";
    echo '<p><a href="reports.php">入力画面に戻る</a></p>';
    exit;
}
if (empty($comment)) {
    echo "<h2>エラー</h2>";
    echo "<p>コメントを入力してください。</p>";
    echo '<p><a href="report.php">入力画面に戻る</a></p>';
    exit;
}
try {

    $pdo->beginTransaction();
    $stmt = $pdo->prepare("INSERT INTO safety_reports (employee_id, status, comment, report_time) VALUES (:employee_id, :status, :comment, NOW())");
    $stmt->bindValue(':employee_id', $_SESSION["employee_id"], PDO::PARAM_STR);
    $stmt->bindValue(':status', $status, PDO::PARAM_STR);
    $stmt->bindValue(':comment', $comment, PDO::PARAM_STR);

    $stmt->execute();

    $pdo->commit();

    

    header("Location: self_reports.php");
    exit;

} catch (PDOException $e) {

    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }

    echo "<h2>エラー</h2>";
    echo "<p>データの保存に失敗しました：" . htmlspecialchars($e->getMessage()) . "</p>";
    echo '<p><a href="report.php">入力画面に戻る</a></p>';
}
?>