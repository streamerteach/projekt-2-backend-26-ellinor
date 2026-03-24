<?php include "../handy_methods.php";
include "../header.php";
$profile = loadProfileByID($conn);

$isLiked = false;
if ($profile["id"] != $_SESSION["uid"]) {
    $isLiked = isLikedByUser($conn, $_SESSION['uid'], $profile['id']);
}
?>

<div id="container">
    <section>
        <div id="profile-header">
        <?php if(!isset($_SESSION["username"])) {
                    header("Location: ../login");
                    exit;
                }
                print('<h1>'.$profile["realname"].'</h1>');?>
                
                <div <?php if ($profile["id"] == $_SESSION['uid']) print("class='hidden'") // gömmer like div om egen profil?>> 
                    <form method="POST" name='give-like' action="../like.php">
                        <input type="hidden" name="liked_id" value="<?= $profile['id'] // skickar med id på profilen i fråga?>"> 
                        <input type="hidden" name="liked_likes" value="<?= $profile['likes']?>"> 
                        <input type="hidden" name="redirect" value="<?= $_SERVER['REQUEST_URI'] ?>">
                        <button type="submit" name='like-button' id='like-button'> <?php if ($isLiked) print("Unlike"); else print("Send a like!"); ?>
                        </button> 
                    </form>
                

                <?php
                print("<div class='like'><img src=");
                if($isLiked){
                    print("'../img/like_filled.png' ");
                }
                else{
                    print("'../img/like.png' ");
                }
                print("alt='likes:'>".$profile["likes"]);
                print("</div>");?> 
                </div>
        </div>
        <article>
            <img class= "pfp" src= "<?php print($profile['profile_picture']);?>"><br>
            <div id='user-pics'>
                <?php print(display_previous_pfp($profile["username"]));?>  
            </div> <br>

            <div><?php  
                print('Username - '.$profile["username"].'<br>'); 
                print('Email - '.$profile["email"].'<br>');
                print('Gender - '.getGender($profile["gender"]).'<br>');
                print('Looking for - '.getPreference($profile["preference"]).'<br>');
                print('Salary - '.$profile["salary"].'€<br>');
                print('Zip code - '.$profile["zipcode"].'<br>');
                print('<div id="bio"><h2>About me:</h2>');
                print("<p>".$profile["bio"].'</p></div>');
                ?>
            </div> <br>

            <div style='display:flex; gap: 8px; flex-direction: row;' 
            <?php if ($profile["id"] != $_SESSION['uid'] && $_SESSION['role'] != 4) print("class='hidden'") // gömmer options div om inte egen profil?>> 
                <form action="logout.php" method="POST" <?php if ($profile["id"] != $_SESSION['uid']) print("class='hidden'")?>>
                    <button type="submit" name="logout">Log out</button>
                </form>
                
                <a href='./editprofile.php?id=<?php print($profile["id"])?>'>
                    <button>Edit profile</button>
                </a> 
            </div>

            
        </article>
    
        <article id="commentsection">
            <h2> Conversations: </h2>
            <?php include "./commentsection.php"?>

            <form method="POST" action="leave_comment.php" <?php if ($profile["id"] == $_SESSION['uid']) print("class='hidden'") // kan inte posta svar frång egen profil tyvärr?>> 
                <input type="hidden" name="recipient_id" value="<?= $profile['id'] ?>">
                <textarea name="comment" required></textarea><br>
                <button type="submit" name="submit_comment">Send message</button>
            </form>
        </article>


        <footer>
            <?php 
                print("Server running on ".$_SERVER['SERVER_SOFTWARE'].", PHP version ".phpversion().".<br>");
            
                $lineCount = substr_count(file_get_contents('./besok.txt'), PHP_EOL);?>
            <p><a href="../rapport.php">Rapport</a></p>
        </footer>
    </section>
</div>
</body>
</html>