<?php
//Starta en session för alla användare 
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

    //funktioner för att översätta databasen till visuellt
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

    // funktion för att printa användare
    function list_users($conn) {
        $sql = "SELECT id, username, realname, profile_picture, salary, gender, preference, likes, email FROM profiles";
        $stmt = $conn->query($sql);

        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($users as $user) {
            print("<div class= 'user-list-entry'> <img src= '".$user['profile_picture']."' class='user-list-pfp'>");
            print("<div class='text-container'><h2>".$user["realname"]."</h2>");
            print("<p>".getGender($user["gender"])."<br>");
            print("Looking for ".getPreference($user["preference"])."<br>");
            if (isset($_SESSION["uid"])) {
                print("Annual salary: ".$user["salary"]."€<br>");
                print("Email: ".$user["email"]."<br>");
            }
            else{
                print("Log in to see more info! <br>");
            }
            print("</p></div>");
            print("<div class='like'><img src='../img/like.png' alt='likes:'>".$user["likes"]."</div></div>");
        }   
        if(!isset($_SESSION["username"])){
            print("<p> Log in to connect! </p>");
        } 
    }

    //funktion för att printa profilbild
    function display_pfp($uID) {
        $sql = "SELECT profile_image FROM profiles WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$uID]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $result['profile_image'];
    }

    function display_previous_pfp($username) {
        $uploadDir = '../img/users/'.$username.'/';

        $existingFiles = glob($uploadDir.'profile*');
        if (count($existingFiles) > 1) {
            for ($i = 0; $i < count($existingFiles) - 1; $i++) {
                print("<img src='".$existingFiles[$i]."'><br>");
            }    
        } 
    }
?>

