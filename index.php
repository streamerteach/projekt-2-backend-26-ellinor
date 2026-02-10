<?php include "handy_methods.php"?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Min första backend webbsida</title>
    <link rel="stylesheet" href="./style.css">
</head>

<body>
    <div id="container">
        <header>
    <div id="logo">Dating site</div>
        <nav>
            <ul>
                <a href="./home"> <li>Home</li></a>
                <a href="./login"> <li>Login</li></a>
            </ul>
        </nav>
</header>
    <section>
        <article>
            <h1>Website</h1>
            <p>Please choose a language:</p>
            <span class ="language"><a href="./home/">English </a></span>
            <span class ="language"><a href="./home/">Swedish </a></span>

            <?php include "uppg1.php"?>
        </article>
    <section>
    </div>
</body>
</html>