<?php
include "../handy_methods.php";

if(isset($_POST["submit_comment"])){
    $sender = $_SESSION['uid'];
    $recipient = (int)$_POST['recipient_id'];
    $comment = test_input($_POST['comment']);

    $sql = "SELECT conversation_id FROM comments WHERE (sender_id = ? AND recipient_id = ?) OR (sender_id = ? AND recipient_id = ?)LIMIT 1";

    $stmt = $conn->prepare($sql);
    $stmt->execute([$sender, $recipient, $recipient, $sender]);
    $conversation = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($conversation) {
        $conversationId = $conversation['conversation_id'];
    } 
    else {
        $stmt = $conn->prepare("SELECT MAX(conversation_id) + 1 FROM comments");
        $stmt->execute();

        $conversationId = $stmt->fetchColumn();
    }

    $stmt = $conn->prepare("INSERT INTO comments(conversation_id, sender_id, recipient_id, comment) VALUES (?, ?, ?, ?)");
    $stmt->execute([$conversationId, $sender, $recipient, $comment]);

    header("Location: index.php?id=".$recipient);
    exit;
}