<?php
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
        <form method="post" action="login.php">

            <div class="textbox">
                <b><label for=""> Email: </label>
                <input type="text" name="naam" id="naam" placeholder="Email" required/><br>
            </div>

            <div class="textbox">
                <label for=""> Wachtwoord: </label>
                <input type="password" name="wachtwoord" id ="wachtwoord" placeholder="Wachtwoord"/><br>
            </div>


            <input type="submit" name="knop" value="Login" />
        </form>
        <br>


<?php

if(isset($_POST["knop"])) {

    $email = $_POST["naam"];
    $wachtwoord = $_POST["wachtwoord"];
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
            $_SESSION["login"] = ["FullName"=> $people[0]["FullName"], "LogonName"=>$account, "Country" => $people[0]["Country"], "Address" => $people[0]["Address"], "PostalCode" => $people[0]["PostalCode"]];
?>
            <div class='LoginMelding'> U bent ingelogd!</div>
                    <script>
                        window.location.href = "http://localhost/NerdyGadgets/";
        </script>

        <?php
        }
        else {
?>
            <div class='LoginMelding'> De gegevens kloppen niet.</div>
        <?php
        }

    }
    elseif (count($people) == 0) { #Wanneer er niks terug komt van de database gebeurd er dit.
        print("<div class='LoginMelding'> De gegevens kloppen niet.</div>");
    }
}


?>

        <br><br>
        <br>
        <a href="index.php">Terug naar homepagina</a>
        <br>
        <a href="registration.php">Registreren</a>
    </div>
</body>
</html>