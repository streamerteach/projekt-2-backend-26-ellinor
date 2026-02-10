<?php
    session_start();
    // ta bort alla session-variabler
    $_SESSION = [];
    session_destroy();

    if(!isset($_SESSION['username'])) {
        header("Location: ../home/index.php");
        exit;
    }
?>