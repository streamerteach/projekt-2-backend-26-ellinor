<?php 
    if(!empty($_SESSION['username'])) {
        $username = $_SESSION['username'];
        print("<h1>Welcome back ".$username."!</h1>");
    } else {
        print("<h1>Welcome to the dating site!</h1>");
    }

    print("Server running on ".$_SERVER['SERVER_SOFTWARE'].", PHP version ".phpversion().".<br>");
    
    //varje besökare (username eller IP) får en egen line i txt filen, så lines = besökare
    $lineCount = substr_count(file_get_contents('./besok.txt'), PHP_EOL);
    print("Number of visitors so far: ".$lineCount);

    // cookie bannern syns bara om användaren inte ännu accepterat/nekat cookies
    if (!isset($_COOKIE["cookie_consent"])) {
        print('<div class="box" id="cookie-banner">');
        print('<p>This site uses cookies!</p>');
        print('<form method="POST" id="cookie-form">');
        print('<button name="accept" value="all">Accept all</button>');
        print('<button name="accept" value="necessary">Only necessary</button>');
        print('</form></div>');
    }
    //honestly har för tillfället inga icke-funktionella cookies så fix för senare (?)
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['accept'])) {
        if ($_POST['accept'] === 'all') {
            setcookie('cookie_consent', 'all', time() + 60*60*24*365, '/', '', false, true);
        } else {
            setcookie('cookie_consent', 'necessary', time() + 60*60*24*365, '/', '', false, true);
        }
    header("Location: ../home");
    exit;
}
?>