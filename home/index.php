<?php include "../handy_methods.php"?>
<?php include "./list_users.php"?>
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

            <?php if(!isset($_SESSION['uid'])){print("<h1>Our users:</h1>");} ?>

            <div id='search-filter-box' <?php if(!isset($_SESSION['uid'])){ print("class='hidden'");} //ingen filtrering för icke-inloggade?>> 
                <h1>Our users:</h1>    
                <form method="GET">
                    <input type ="checkbox" name ='show-preferred' id ='show-preferred'> <label for="show-preferred">Show only preferred matches</label> <br>
                    Sort by:
                    <select name="sort">
                        <option value="salary_desc">Salary (highest first)</option>
                        <option value="salary_asc">Salary (lowest first)</option>
                        <option value="likes_desc">Most likes</option>
                        <option value="likes_asc">Fewest likes</option>
                    </select>
                    <button type="submit">Apply</button>
                </form>
            </div>

            <article class='user-list'>
                <?php list_users($conn)?>
            </article>
            <footer>
                <?php 
                    print("Server running on ".$_SERVER['SERVER_SOFTWARE'].", PHP version ".phpversion().".<br>");
                
                    $lineCount = substr_count(file_get_contents('./besok.txt'), PHP_EOL);
                    print("Number of visitors so far: ".$lineCount."<br>");?>
                <p><a href="../rapport.php">Rapport</a></p>
            </footer>
        </section>
    </div>
</body> 
<script src="countdown.js"></script>
</html>