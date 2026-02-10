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

    // funktion för att printa användare
    function list_users() {
        $usersFile = "../login/users.json";
        if (file_exists($usersFile)) {
            $users = json_decode(file_get_contents($usersFile), true);
            foreach ($users as $user) {
                print("<div><img src= ".display_pfp($user["username"])." class='user-list-pfp'>");
                print("<p>".$user["username"]."</p></div>");
            }
        } else {
            print("<p>No users found.</p>");
        }
    }

    //funktion för att printa profilbild
    function display_pfp($username) {
        $uploadDir = '../img/users/'.$username.'/';

        $existingFiles = glob($uploadDir.'profile*');
        if (count($existingFiles) > 0) {
            // välj den senast uppladdade profilbilden
            $latestFile = end($existingFiles);
            return "'".$latestFile."'";
        } else {
        return "'../img/default_pfp.jpg'";
        }
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

