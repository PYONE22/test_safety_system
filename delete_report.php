<?php
session_start();
require_once 'db.php';

$id = $_GET["id"] ?? '';

echo $id; // ← test

if (empty($id)) {
    die("ID error");
}

try {

    $stmt = $pdo->prepare("
        DELETE FROM safety_reports
        WHERE report_id = :id
    ");

    $stmt->execute([
        ':id' => $id
    ]);

    header("Location: self_reports.php");
    exit;

} catch(PDOException $e) {

    die($e->getMessage());
}
?>