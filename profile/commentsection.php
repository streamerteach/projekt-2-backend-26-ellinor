<?php
    $commentsFile = "comments.json";

    //hämta tidigare kommentarer
    if (file_exists($commentsFile)) {
        $comments = json_decode(file_get_contents($commentsFile), true);
    } else {
        $comments = [];
    }

    // ta emot nya kommentarer
    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["submit_comment"])) {
        $username = $_SESSION["username"];
        $comment  = trim($_POST["comment"]);

        array_unshift($comments, [
            "user" => $username,
            "time" => date("Y-m-d H:i:s"),
            "comment" => trim($_POST["comment"])
        ]);

        file_put_contents($commentsFile, json_encode($comments, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

        header("Location: ./index.php");
        exit;
    }

    foreach ($comments as $c) {
        print("<div class='comment'>");
        print("<b>". htmlspecialchars($c['user']) ."</b>      ");
        print("<small>". $c['time'] . "</small><br>");
        print("<p>". htmlspecialchars($c['comment']) ."</p><br>");
        print("</div>");
    }