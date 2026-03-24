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
$likes = (int)$_POST['liked_likes'];

try {// checka like 
    $stmt = $conn->prepare("SELECT 1 FROM likes WHERE liker_id = ? AND liked_id = ?");
    $stmt->execute([$liker, $liked]);

    if ($stmt->fetch()) { //om resultat finns, d.v.s. true, -> unlike
        $stmt = $conn->prepare("DELETE FROM likes WHERE liker_id = ? AND liked_id = ?");
        $stmt->execute([$liker, $liked]);

        $likes -= 1;
    } else { //like 
        $stmt = $conn->prepare("INSERT INTO likes (liker_id, liked_id) VALUES (?, ?)");
        $stmt->execute([$liker, $liked]);

        $likes += 1;
    }
    $stmt = $conn->prepare("UPDATE profiles SET likes = $likes WHERE id = ?");
    $stmt->execute([$liked]);
} 
catch (PDOException $e) {
    header("Location: ./home/");
    exit;
}

$redirect = $_POST['redirect'] ?? '../home';
header("Location: " .$redirect);
exit;