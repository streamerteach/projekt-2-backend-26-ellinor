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
                </div>
                <div class='box'>
                    Change profile picture: <form method="POST" enctype="multipart/form-data">
                                                <input type="file" name="profile_picture" required>
                                                <button type="submit" name="upload_pfp">Upload</button>
                                            </form>
                    <?php include "./pfp.php"?>
                </div> <br>

                <div>
                    <form id= 'edit-profile' method="POST">
                        Username: <input type="text" name = "username" value="<?php print($userInfo["username"])?>" required><br>
                        Email: <input type="text" name = "email" value="<?php print($userInfo["email"])?>" required> <br>
                        Annual salary: <input type="int" name = "salary" value="<?php print($userInfo["salary"])?>" required><br>
                        Zip code: <input type="int" name = "zip" value="<?php print($userInfo["zipcode"])?>" required><br>
                        <p>Gender:<br>
                            <input type="radio" id="woman" name="gender" value="1" required>
                            <label for="woman">woman</label><br>
                            <input type="radio" id="man" name="gender" value="2">
                            <label for="man">man</label><br>
                            <input type="radio" id="non-binary" name="gender" value="3">
                            <label for="non-binary">non-binary</label><br>  
                            <input type="radio" id="other" name="gender" value="4">
                            <label for="other">other / prefer not to say</label>
                        </p>
                        <p>Dating preference: <br>
                            <input type="radio" id="women" name="preference" value="1" required>
                            <label for="women">women</label><br>
                            <input type="radio" id="men" name="preference" value="2">
                            <label for="men">men</label><br>
                            <input type="radio" id="both" name="preference" value="3">
                            <label for="both">both</label><br>
                            <input type="radio" id="other" name="preference" value="4">
                            <label for="other">other</label><br>
                            <input type="radio" id="all" name="preference" value="5">
                            <label for="all">all</label>
                        </p>
                        <h2>About me:</h2>
                        <textarea name="bio" required><?php print($userInfo["bio"])?> </textarea><br>
                        </form>
                    </div>

                    <div style='display:flex; gap: 8px; flex-direction: row;'>
                    <button type ="submit" name= "saveEdits" form='edit-profile'>Confirm changes</button>
                    <?php include "./savechanges.php"?>
                    <a href="./index.php"> <button class= 'white-button'>Discard changes</button> </a>

                    <button id="deleteButton" class= 'white-button' type="button" name="deleteButton">Delete profile</button>
                </div>
                
                <div id="deleteWindow" class="<?php echo isset($_SESSION['error']) ? '' : 'hidden'; ?>">
                    <div id="deleteText">
                        <?php if (isset($_SESSION["error"])){
                            print("<p class='msg'>" . $_SESSION['error'] . "</p>");
                            unset($_SESSION['error']);
                        }?>
                        <p>Are you sure you want to permanently delete your profile?</p>
                        <p>Enter password to confirm:</p>

                        <form action="logout.php" method="POST">
                            <input type="password" name = "passConfirm" required> <br>
                            <button type="submit" name="deleteConfirm">Confirm</button>
                        </form>
                        <button id="cancelDelete" type="button">Cancel</button>
                    </div>
                </div>
            </article>
            <footer>
            <?php 
                print("Server running on ".$_SERVER['SERVER_SOFTWARE'].", PHP version ".phpversion().".<br>");
            
                //varje besökare (username eller IP) får en egen line i txt filen, så lines = besökare
                $lineCount = substr_count(file_get_contents(('../home/besok.txt')), PHP_EOL);
                print("Number of visitors so far: ".$lineCount);
            ?>
            </footer>
        </section>
    </div>
</body>
<script src="deleteprofile.js"></script>
</html>