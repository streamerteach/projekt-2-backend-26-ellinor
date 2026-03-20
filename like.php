<?php
include "handy_methods.php";

if (!isset($_POST['like-button'])) {
    return;
}

if (empty($_SESSION['uid'])) {
    header("Location: ./login/");
    exit;
}

$liker = (int)$_SESSION['uid'];
$liked = (int)$_POST['liked_id'];

try {
    $stmt = $conn->prepare("INSERT INTO likes (liker_id, liked_id) VALUES (?, ?)");
    $stmt->execute([$liker, $liked]);

    $stmt = $conn->prepare("UPDATE profiles SET likes = likes + 1 WHERE id = ?");
    $stmt->execute([$liked]);

} catch (PDOException $e) {
    
}
$redirect = $_POST['redirect'] ?? '../home';
header("Location: " .$redirect);
exit;