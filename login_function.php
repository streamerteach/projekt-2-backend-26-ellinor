<?php
// fortsätter inte om inte login-formuläret är skickat
if (!isset($_POST['login'])) {
    return;
}

if (!empty($_SESSION["username"])) {
    header("Location: ../profile");
    exit;
}

// Kolla om det finns data i post-fältet
if (!empty($_POST["username"])) {
    // kom ihåg att alla användardata är skadlig
    $username = test_input($_POST["username"]);
    $password = test_input($_POST["password"]);

    $users = json_decode(file_get_contents('users.json'), true);

    if (!isset($users[$username])) {
        print("<p class='msg'>Check input</p>");
        return;
    } else {
        $hashedPassword = $users[$username]['password'];

        if (!password_verify($password, $hashedPassword)) {
            print("<p class='msg'>Check input</p>");
            return;
        }

        $_SESSION["username"] = $username;
        setcookie("username", $username, time() + (86400 * 30), "/"); //86400s = 1 dag


        // kolla när användaren senast loggat in (touch(username.txt) exekverades)
        $lastVisit = fileatime("../profile/user_visits/$username.txt");

        if ($lastVisit !== false) {
            $_SESSION["last_visit"] = date("d-m-Y H:i:s", $lastVisit);
        } else {
            $_SESSION["last_visit"] = "First visit!";
        }

        touch("../profile/user_visits/".$username.".txt"); // uppdatera besökstid
        header("Location: ../profile");
        exit;
    }
}


