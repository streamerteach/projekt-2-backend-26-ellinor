<?php include "../handy_methods.php"?>
<?php include "../header.php"?>

<link rel="stylesheet" href="../style.css">

    <div id="container">
        <section>
            <?php if(!isset($_SESSION["username"])) {
                        header("Location: ../login");
                        exit;
                    }
                    print('<h1>'.$userInfo["realname"].'</h1>');
            ?> 
            <article>
                <img class= "pfp" src= "<?php print($userInfo['profile_picture']);?>"><br>
                <div id='user-pics'>
                    <?php print(display_previous_pfp($_SESSION["username"]));?>
                </div> <br>

                <div><?php  
                    print('Username - '.$userInfo["username"].'<br>'); 
                    print('Email - '.$userInfo["email"].'<br>');
                    print('Salary - '.$userInfo["salary"].'€<br>');
                    print('Zip code - '.$userInfo["zipcode"].'<br>');
                    print('<div id="bio"><h2>About me:</h2>');
                    print("<p>".$userInfo["bio"].'</p></div>');
                    ?>
                </div> <br>

                <?php // användares senaste besök
                    print("<p> Last login: ".$_SESSION['last_visit']."</p>");
                ?>

                <div style='display:flex; gap: 8px; flex-direction: row;'>
                    <form action="logout.php" method="POST">
                        <button type="submit" name="logout">Log out</button>
                    </form>
                    
                    <a href="./editprofile.php">
                        <button>Edit profile</button>
                    </a> 
                </div>
            </article>
        
            <article id="commentsection">
                <form method="POST">
                    <textarea name="comment" required></textarea><br>
                    <button type="submit" name="submit_comment">Post comment</button>
                </form>
                <h2> Comments: </h2>
                <?php include "./commentsection.php"?>
            </article>
            <footer>
            <?php 
                print("Server running on ".$_SERVER['SERVER_SOFTWARE'].", PHP version ".phpversion().".<br>");
            
                //varje besökare (username eller IP) får en egen line i txt filen, så lines = besökare
                $lineCount = substr_count(file_get_contents('../home/besok.txt'), PHP_EOL);
                print("Number of visitors so far: ".$lineCount);
            ?>
            </footer>
        </section>
    </div>
</body>
</html>