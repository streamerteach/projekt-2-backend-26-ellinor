<?php include "../handy_methods.php"?>
<?php include "../header.php"?>

    <div id="container">
        <section>
            <article>
                <?php include "./splashpage.php"?>
                <?php include "./visit_log.php"?>
            </article>
            
            <article>
                <h2>Countdown to next date:</h3>
                <button type = "button" id="toggleDateInput">Enter new date</button><br>

                <form method="post" class="hidden" id="dateInput">
                    <label> Enter date and time of date:
                        <input type="datetime-local" name="date" required>
                    </label>
                    <button type="submit">Confirm date</button>
                </form><br>
                <?php include "./countdown.php"?>
            
            </article>
            <h2>Our users:</h2>
            <article class='user-list'>
                <?php list_users($conn)?>
            </article>
            <footer>
            <?php 
                print("Server running on ".$_SERVER['SERVER_SOFTWARE'].", PHP version ".phpversion().".<br>");
            
                //varje besökare (username eller IP) får en egen line i txt filen, så lines = besökare
                $lineCount = substr_count(file_get_contents('./besok.txt'), PHP_EOL);
                print("Number of visitors so far: ".$lineCount);
            ?>
            </footer>
        </section>
    </div>
</body> 
<script src="countdown.js"></script>
</html>