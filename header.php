<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dating site</title>
    <link href="https://fonts.googleapis.com/css2?family=Lexend" rel="stylesheet">
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <header>
    <div id="logo">Dating site</div>
        <nav>
            <ul>
                <a href="../home"> <li>Home</li></a>
                <?php
                    if(!empty($_SESSION["username"])){
                        print("<a href='../profile'> <li>Profile</li> <img src=".display_pfp($_SESSION["username"])." id='nav-pfp'></a>");
                    } else{
                        print('<a href="../login"> <li>Login</li></a>');
                    }
                ?>  
            </ul>
        </nav>
</header>