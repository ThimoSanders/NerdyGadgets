<?php include('registration2.php');
include __DIR__ . "/header.php"; ?>
<!DOCTYPE html>
    <html>
    <head>
        <title>Registratie</title>
        <link rel="stylesheet" type="text/css" href="Public/CSS/style_login.css">
    </head>
    <body>
    <div class="login-box">
        <h1>Registreren</h1>
        <form method="post" action="registration.php">
            <?php
            include('errors.php'); ?>
            <div class="textbox">
            <label><b>Naam:</label>
                <div class="textbox">
                    <input type="text" name="username" value="" placeholder="Naam">
                </div>
                    <label>Email:</label>
                <div class="textbox">
                    <input type="email" name="email" value="" placeholder="Email">
                </div>
                    <label>Wachtwoord:</label>
                <div class="textbox">
                    <input type="password" name="password_1" placeholder="Wachtwoord">
                </div>
                    <label>Bevestig wachtwoord:</label>
                <div class="textbox">
                    <input type="password" name="password_2" placeholder="wachtwoord">
                </div>

                <input type="submit" name="reg_user" value="Registreren" />
        </form>
        </div>
    <h4>Al een Lid? <a href="login.php">Inloggen</a>




    </body>
    </html>

<?php
$host = "localhost";
$databasename = "nerdygadgets";
$user = "root";
$pass = "";
$port = 3306;
$connectie = mysqli_connect($host, $user, $pass, $databasename, $port);

$sql = "SELECT * FROM people";
$result = mysqli_query($connectie, $sql);
$people = mysqli_fetch_all($result,MYSQLI_ASSOC);
?>

