<?php
session_start();
include "connect.php";

include __DIR__ . "/header.php";

?>
    <!DOCTYPE html>
    <html>
    <head>
        <meta charset="UTF-8"><title>Inloggen</title></head>
    <link rel="stylesheet" type="text/css" href="Public/CSS/style_login.css">
    <body>
    <div class="login-box">
        <h1>Inloggen</h1><br><br>
        <form method="get" action="login.php">
            <label for=""> Naam: </label>
            <input type="text" name="naam" id="naam" required/><br>
            <label for=""> Wachtwoord: </label>
            <input type="password" name="wachtwoord" id ="wachtwoord"/><br>
            <input type="submit" name="knop" value="Login" />
        </form>
        <br><br>



<?php

if(isset($_GET["knop"])) {

    $email = $_GET["naam"];
    $wachtwoord = $_GET["wachtwoord"];

    //VERBINDING MAKEN - Hier geef je de rechten en de locatie waar de database staat.
    $host = "localhost";
    $databasename = "nerdygadgets";
    $user = "root";
    $pass = "";
    $port = 3306;
    $connection = mysqli_connect($host, $user, $pass, $databasename, $port);

    //DB server ‘voorbereiden’ dat er SQL statement aankomt met parameter
    $statement = mysqli_prepare($connection, "SELECT * FROM people WHERE LogonName=?");

    // ? koppelen aan variabele
    mysqli_stmt_bind_param($statement, 's', $email); // i = integer; s = string;

    //query uitvoeren
    mysqli_stmt_execute($statement);

    //resultaat ophalen
    $result = mysqli_stmt_get_result($statement);

    //RESULTAAT UITLEZEN - fetch alle gegevens in een associative array $medewerkers
    $people = mysqli_fetch_all($result,MYSQLI_ASSOC);

    //VERVINDING OPRUIMEN - verbinding sluiten met de database
    mysqli_close($connection);

    #Kijkt of er een account bestaat met de ingevulde account naam.
    if (count($people) > 0) {
        $account = $people[0]["LogonName"];
        $password = $people[0]["HashedPassword"];

        if (password_verify($wachtwoord, $password)) {
            print("test");
        }
        else {
            print("Het werkt niet.");
        }

    }
    elseif (count($people) == 0) { #Wanneer er niks terug komt van de database gebeurd er dit.
        print("Er bestaat geen account met de ingevulde gegevens.");
    }

}


?>

        <br><br>
        <br>
        <a href="index.php">Terug naar homepagina</a>
        <a href="registreer.php">Registreren</a>
    </div>
</body>
</html>