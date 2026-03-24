<?php
$recipientId = $profile['id'];
$userId = $_SESSION['uid'];

 //för egen profil visa alla kommentarer till en själv
if (($recipientId == $userId)){
    $sql = "SELECT * FROM profiles INNER JOIN comments ON profiles.id = comments.sender_id 
    WHERE comments.recipient_id = $recipientId OR comments.sender_id = $recipientId 
    ORDER BY conversation_id DESC, comments.id ASC";

    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $comments = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $conversations = [];
    foreach ($comments as $comment) {
        $conversationId = $comment['conversation_id'];
        $conversations[$conversationId][] = $comment;
    }
}
else{ // för andras profiler visa endast egen konversation med profilen
    $sql = "SELECT conversation_id FROM comments WHERE (sender_id = ? AND recipient_id = ?) OR (sender_id = ? AND recipient_id = ?)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$userId, $recipientId, $recipientId, $userId]);

    $conversation = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($conversation) {
        $conversationId = $conversation['conversation_id'];

        $sql = "SELECT * FROM comments INNER JOIN profiles ON profiles.id = comments.sender_id WHERE conversation_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$conversationId]);

        $comments = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    $conversations = [];
    if (!empty($comments)) {
        foreach ($comments as $comment) {
            $conversations[$conversationId][] = $comment;
        }
    }
}

// printa konversationer
if (!empty($conversations)) {
    foreach ($conversations as $conversationId => $messages) {
        //hittar rätt id att länka till för att svara 
        $firstMessage = $messages[0];
        if ($firstMessage['sender_id'] == $_SESSION['uid']) {
            $linkId = $firstMessage['recipient_id'];
        } else {
            $linkId = $firstMessage['sender_id'];
        }

        print("<a href='../profile/index.php?id=".$linkId."' class='user-link'>");
        print("<div class='conversation'>");
        foreach ($messages as $comment) {
            print("<div class='comment'>");
            print("<h3>".$comment['username']."</h3>");
            print("<p>".$comment['comment']."</p>");
            print("</div>");

            if ($_SESSION['role'] == 4) {
                print("<form method='POST' action='delete_comment.php'>
                        <input type='hidden' name='comment_id' value='".$comment['id']."'>
                        <button type='submit' class='small-button'>Delete comment</button>
                    </form>");
            }
        }

        print("</div>");
        print("</a>");
    }
}
else{
    print("You haven't started a conversation yet.");
}
