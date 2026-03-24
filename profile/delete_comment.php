<?php 
require_once "../handy_methods.php";

if ($_SESSION['role'] != 4) {
    header("Location: ../index.php");
    exit;
}

$commentId = (int)$_POST['comment_id'];

$stmt = $conn->prepare("
DELETE FROM comments
WHERE id = ?
");

$stmt->execute([$commentId]);

header("Location: " . $_SERVER['HTTP_REFERER']);
exit;