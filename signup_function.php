<?php
    if (!isset($_POST['signup'])) {
        return;
    }
    if (isset($_POST['signup'])) {
        $email = test_input($_POST['email']);
        $username = test_input($_POST['username']);
    }

    $random_password = bin2hex(random_bytes(4));

    $usersFile = 'users.json';
    $users = json_decode(file_get_contents($usersFile), true);

    if (isset($users[$username])) {
        print("<p class='msg'>Invalid username</p>");
        return;
    }

    $users[$username] = [
        'username' => $username,
        'email' => $email,
        'password' => password_hash($random_password, PASSWORD_DEFAULT)
    ];

    file_put_contents($usersFile, json_encode($users, JSON_PRETTY_PRINT));

    mail($email, "Welcome!", "Your password is: $random_password");