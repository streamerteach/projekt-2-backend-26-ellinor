<?php
//Starta en session för alla användare på all sidor
    session_start();
//Databaskonfiguration
    $servername= "localhost";
    $dbname = "romanell";
    $dbusername = "romanell";
    include "hemlis.php";

    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $dbusername, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    error_reporting(E_ALL);
    ini_set('display_errors', '1'); //om live server, DONT DISPLAY ERRORS! 
    date_default_timezone_set('Europe/Helsinki');


    //funktion för input sanitisation
    function test_input($data) {
        $data = trim($data); //ta bort white space
        $data = stripslashes($data); //ta bort slashes 
        $data = htmlspecialchars($data); //"översätter" till html språk (ex < till &lt)
        return $data;
    }

    //funktion för att printa profilbild
    function display_pfp($uID) {
        $sql = "SELECT profile_image FROM profiles WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$uID]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            return null;
        }

        return $user['profile_image'];
    }

    //funktion för att printa tidigare profilbilder på profil för given användare
    function display_previous_pfp($username) {
        $uploadDir = '../img/users/'.$username.'/';

        $existingFiles = glob($uploadDir.'profile*');
        if (count($existingFiles) > 1) {
            for ($i = 0; $i < count($existingFiles) - 1; $i++) {
                print("<img src='".$existingFiles[$i]."'><br>");
            }    
        } 
    }

    // funktion för laddning av profil från användarID
    function loadProfileByID($conn){
        if (isset($_GET['id'])) {
            $profileId = (int)$_GET['id'];
        } 
        else { // default egen profil
            $profileId = $_SESSION['uid'];
        }

        $sql = "SELECT * FROM profiles WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$profileId]);

        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        return $user;
    } 
    
    //funktioner för att översätta registrerat kön o prefrens
    function getGender($genderCode){
        $genders = [1 => "woman", 2 => "man", 3 => "nonbinary", 4 => "other / prefer not to say"];

        $gender = $genders[$genderCode];
        return $gender;
    }
    function getPreference($preferenceCode) {
        $preferences = [1 => "women", 2 => "men", 3 => "men or women", 4 => "other", 5 => "any"];

        $preference = $preferences[$preferenceCode];
        return $preference;
    } 

    //funktion för o lista ut om en profil är gillad av user
    function isLikedByUser($conn, $uID, $profileID){
        $sql = "SELECT * FROM likes WHERE liker_id = ? AND liked_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$uID, $profileID]);
        // returnerar true om uID finns i profilens likes, annars false
        return $stmt->fetch(PDO::FETCH_ASSOC) !== false;
    }
    
    // funktion för att gömma massa fula print statements
    function printUserCards($users, $conn){
        foreach ($users as $user) {
            $loggedIn = isset($_SESSION['uid']); //true eller false
            if ($loggedIn) // länkar till profil för annonsen (för inloggade användares bruk)
                print("<a href='../profile/index.php?id=".$user["id"]."' class='user-link'>"); 

            print("<div class= 'user-list-entry'>");
            print("<img src= '".$user['profile_picture']."' class='user-list-pfp'>");
            print("<div class='text-container'><h2>".$user["realname"]."</h2>");
            print("<p>".getGender($user["gender"])."<br>");
            print("Looking for ".getPreference($user["preference"])."<br>");
            
            // mer info för inloggade
            if ($loggedIn) {
                print("Annual salary: ".$user["salary"]."€<br>");
                print("Email: ".$user["email"]."<br>");
            }
            else
                print("Log in to see more info! <br>");
            
            print("</p></div>");

            print("<div class='like'><img src=");
            
            if ($loggedIn && isLikedByUser($conn, $_SESSION['uid'], $user["id"])) { 
                // triggas endast om inloggad OCH profil är gillad
                print("'../img/like_filled.png' alt='likes:'>".$user["likes"]."</div></div>");
            } 
            else { // om inte inloggad eller inte gillad 
                print("'../img/like.png' alt='likes:'>".$user["likes"]."</div></div>");
            }

            if ($loggedIn)
                print("</a>");
        }  

        if(!$loggedIn)
            print("<p> Log in to make searches and connect! </p>");
    }
?>

