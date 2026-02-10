<?php include "../handy_methods.php"?>
<?php include "../header.php"?>

<link rel="stylesheet" href="../style.css">

    <div id="container">
        <section>
            <?php if(!isset($_SESSION["username"])) {
                        header("Location: ../login");
                        exit;
                    }
                    print('<h1>'.$_SESSION["username"].'</h1>')
            ?> 
            <article>
                <img class= "pfp" src=<?php print(display_pfp($_SESSION["username"]))?>><br>
                <div id='user-pics'>
                    <?php print(display_previous_pfp($_SESSION["username"]))?>
                </div> <br>

                <div class='box'>
                    Change profile picture: <form method="POST" enctype="multipart/form-data">
                                                <input type="file" name="profile_picture" required>
                                                <button type="submit" name="upload_pfp">Upload</button>
                                            </form>
                    <?php include "./pfp.php"?>
                </div>
                <?php // användares senaste besök
                    print("<p> Your last login: ".$_SESSION['last_visit']."</p>");
                ?>
                <form action="logout.php" method="POST">
                    <button type="submit" name="logout">Log out</button>
                </form>
            </article>
        
            <article id="commentsection">
                <form method="POST">
                    <textarea name="comment" required></textarea><br>
                    <button type="submit" name="submit_comment">Post comment</button>
                </form>
                <h2> Comments: </h2>
                <?php include "./commentsection.php"?>
            </article>
        </section>
    </div>
</body>
</html>