<?php include "../handy_methods.php"?>
<?php include "../header.php"?>
<link rel="stylesheet" href="./style.css">

    <section>
        <article>
            <?php include "./login_function.php"?>
            <?php include "./signup_function.php"?>
        </article>
        <article id="login-form">
            <?php
                $form = $_GET['form'] ?? 'login';
                if ($form === 'signup') {
                    include 'signup.php';
                } else {
                    include 'login.php';
                }
            ?>
        </article>
    <section>
</body>
</html>