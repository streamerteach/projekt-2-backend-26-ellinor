<?php
    include "../handy_methods.php";
    if (isset($_POST['logout'])) {
        session_start();
        // ta bort alla session-variabler
        $_SESSION = [];
        session_destroy();

        if(!isset($_SESSION['username'])) {
            header("Location: ../home/index.php");
            exit;
        }
    }

    if (isset($_POST['deleteConfirm'])) {
        $sql = "SELECT passhash FROM profiles WHERE id = ?"; 
        $stmt = $conn->prepare($sql);
        $stmt->execute([$_SESSION['uid']]);
        $profile = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!password_verify($_POST['passConfirm'], $profile['passhash'])) {
            $_SESSION['error'] = "Check input";
            header("Location: editprofile.php");
            exit;
        }
        
        $sql = "DELETE FROM profiles WHERE id = ?"; 
        $stmt = $conn->prepare($sql);
        $stmt->execute([$_SESSION['uid']]);

        $_SESSION = [];
        session_destroy();

        if(!isset($_SESSION['username'])) {
            header("Location: ../home/index.php");
            exit;
        }
    }
?>