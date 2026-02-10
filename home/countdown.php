<?php 
    print("Today is ".date("l")." the ".date("j")." of ".date("F").", week ".date("W"));

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['date'])) {
        $date = new DateTime($_POST['date'], new DateTimeZone('Europe/Helsinki'));
        $dateConverted = $date->getTimestamp() * 1000;

        print("<br>Next date is on ".$date->format('l')." the ".$date->format('j')." of ".$date->format('F')." <div class='box' id='countdown-box'> Date starts in: <p id='countdown'></p></div>");
    }
?>

<script>
    let date_converted = <?= $dateConverted ?>;
    let remaining_time = date_converted - Date.now();

    function updateCountdown() {
        if (remaining_time <= 0) {
            document.getElementById("countdown").textContent = "Time for your date!";
            return;
        }

        const seconds = Math.floor(remaining_time / 1000) % 60;
        const minutes = Math.floor(remaining_time / (1000 * 60)) % 60;
        const hours   = Math.floor(remaining_time / (1000 * 60 * 60)) % 24;
        const days    = Math.floor(remaining_time / (1000 * 60 * 60 * 24));

        document.getElementById("countdown").innerHTML =
            `${days} days, ${hours} hours, ${minutes} minues, and ${seconds} seconds`;
        remaining_time -= 1000;
    }

    updateCountdown();
    setInterval(updateCountdown, 1000);
</script>
