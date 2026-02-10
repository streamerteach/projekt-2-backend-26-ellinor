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
            <?php include "../model_profiles.php"?>
            <article class='user-list'>
                <?php print(list_users())?>
            </article>
        </section>
    </div>
</body> 
<script src="countdown.js"></script>
</html>