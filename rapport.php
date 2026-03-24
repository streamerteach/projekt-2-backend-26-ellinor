<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dating site</title>
    <link href="https://fonts.googleapis.com/css2?family=Lexend" rel="stylesheet">
    <link rel="stylesheet" href="./style.css">
</head>
<body>
    <header>
    <div id="logo">Dating site</div>
        <nav>
            <ul>
                <a href="./home"> <li>Home</li></a>
                <?php
                    if(!empty($_SESSION["uid"])){
                        print("<a href='./profile'> <li>Profile</li> <img src= '".$userInfo['profile_picture']."' id='nav-pfp'></a>");
                    } else{
                        print('<a href="./login"> <li>Login</li></a>');
                    }
                ?>  
            </ul>
        </nav>
</header>

<div id="container">
    <section>
        <article id='rapport'>
            <h1>Rapport</h1>
            <p>
                <h2>Profiles</h2>
                För denna webbsidas funktion används en databas för att lagra information om dess användare. I databasen finns
                tre olika tabeller, vilka kan beskrivas som samlingar av data som hör ihop. En av dessa tabeller heter "profiles". 
                I "profiles" finns den info som är direkt relaterad till de profiler användare skapar på webbsidan. 
                Här finns deras personliga info och annan data som direkt berör profilen i sig. Lösenord sparas enkrypterade, 
                d.v.s. att de går inte att läsa av människor direkt från databasen för användarsäkerhetens skull. Härifrån går det
                att hämta användarinformation från databasen eftersom varje användare har ett unikt id som fungerar som nyckel. 
            </p>
            
            <p>
                Ett exempel på en rad (en användare) i "profiles" tabellen:
            <img src="./img/profiles_table.png" class="rapport-bild">
            </p>

            <p>
                <h2>Likes</h2>
                Den andra tabellen som jag skapat heter "likes". Varje rad i denna tabell representerar en gillning någon har givit. 
                Via "likes" tabellen håller sidan koll på vilken användare som gillat vem.
                Det är inte härifrån själva antalet likes per profil hämtas, utan summan finns i "profiles" tabellen, 
                eftersom det är info som beskriver profilen.
            </p>
            <p>
                Ett exempel på en rad (en like) i "likes" tabellen: <br>
                <img src="./img/likes_table.png" class="rapport-bild"><br>
                I detta exempel ser vi att användare 7 har gillat både profil 1 och 5, och kommer se en ikon på deras profiler
                som påvisar detta visuellt.
            </p>

            <p>
                <h2>Comments</h2>
                Den tredje tabellen som jag skapat heter "comments". Här sparas såklart alla kommentarer som användare skickar sinsemellan,
                men också sparar id på vem som skickat vad och vem som är mottagare. Med dessa nycklar vet webbsidan vilka kommentarer som ska 
                visas på vilken profil, och ser till att konversationer visas endast mellan de två inblandade profilerna. Den är också kopplad
                till "profiles", och eftersom användar-id är unik och primärninyckel i profiles, kan man länka dem för att lösa ut användarnamn
                på den som lämnat kommentaren. 
            </p>
            <p>
                Ett exempel på en rad (en kommentar) i "comments" tabellen: <br>
                <img src="./img/comments_table.png" class="rapport-bild"><br>
                I detta exempel ser vi att användare 5 har skickat en kommentar till användare 7, och kommentarens innehåll. 
                Kommentaren har också ett unikt id för att möjliggöra radering i efterhand, samt konversations-id för att hålla
                koll på vilka kommentarer som hör samman.
            </p>
        
            <p>
                <h2>Reflektion</h2>
                Detta projekt har tagit upp mer tid än förväntat. Jag körde fast rätt så ofta och fick gå tillbaka och
                fixa saker som jag redan trott varit färdiga flera gånger om, vilket gjorde att mitt tidsomdöme varit helt fel. 
                Jag känner mig alltid mer inspirerad och att jag har bättre planeringsförmåga desto mer jag lärt mig,
                så i slutändan av projektet har jag gått tillbaka och fixat mycket som jag inte längre varit nöjd med o.s.v.
                Projekt 2 har tagit totalt ungefär 35 timmar att skapa, trots att det var baserat på projekt 1 och redan hade 
                stommen klar. 
            </p>
            <p>
                Tack för kursen, den har varit intressant och lärorik, och det har varit roligt att bekanta sig med databaser! 
            </p>
        </article>
    </section>
</div>
</body> 
</html>