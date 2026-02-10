<?php 
if (isset($_SESSION["username"])) {                 //räknar antingen användare...
    $username = $_SESSION["username"];

    if (!str_contains(file_get_contents('./besok.txt'), $username)) { 
        $myfile = fopen("./besok.txt", "a") or die("Error: Unable to open file!");
        $txt = "<br>".$username."  visited on  ".date("j").".".date("m").".".date("Y")." at ".date("H:i:s")."\n";

        fwrite($myfile, $txt);
        fclose($myfile);
    } else {    //användaren finns redan i filen, räkna inte pånytt 
        return;
    }
} else if (empty($_SESSION["username"])) {          //...eller ip adress om användare inte finns 
    $user = $_SERVER['REMOTE_ADDR'];
    if (str_contains(file_get_contents('./besok.txt'), $user)) {
        return;
    } else {
        $myfile = fopen("./besok.txt", "a") or die("Error: Unable to open file!");
        $txt = "<br>".$user."  visited on  ".date("j").".".date("m").".".date("Y")." at ".date("H:i:s")."\n";

        fwrite($myfile, $txt);
        fclose($myfile);
    }
}