<?php
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
$FullName = "";
$EmailAddress = "";
$errors = array();

$host = "localhost";
$databasename = "nerdygadgets";
$user = "root";
$pass = "";
$port = 3306;
$connectie = mysqli_connect($host, $user, $pass, $databasename, $port);

$sql = "SELECT * FROM people";
$result = mysqli_query($connectie, $sql);
$people = mysqli_fetch_all($result,MYSQLI_ASSOC);

if (isset($_POST['reg_user'])) {
    $FullName = mysqli_real_escape_string($connectie, $_POST['username']);
    $EmailAddress = mysqli_real_escape_string($connectie, $_POST['email']);
    $password_1 = mysqli_real_escape_string($connectie, $_POST['password_1']);
    $password_2 = mysqli_real_escape_string($connectie, $_POST['password_2']);

    if (empty($FullName)) {
        array_push($errors, "Username is required");
        echo "<br> Naam is niet ingevuld ";
    }
    if (empty($EmailAddress)) {
        array_push($errors, "Email is required");
        echo "<br> Email is niet ingevuld ";
    }
    if (empty($password_1)) {
        array_push($errors, "Password is required");
        echo "<br> Wachtwoord is niet ingevuld";
    }
    if ($password_1 != $password_2) {
        array_push($errors, "The two passwords do not match");
        echo "<br> De twee wachtwoorden komen niet overheen ";
    }

// a user does not already exist with the same username and/or email
    $user_check_query = "SELECT * FROM people WHERE FullName='$FullName' OR EmailAddress='$EmailAddress' LIMIT 1";
    $result = mysqli_query($connectie, $user_check_query);
    $user = mysqli_fetch_assoc($result);

// if Email already exists
    if ($user) {
        if ($user['LogonName'] === $EmailAddress) {
            array_push($errors, "email already exists");
            echo "<br> Email is al in gebruik";
        }
    }
// register user if there are no errors
    if (count($errors) == 0) {
        $password = password_hash($password_1, PASSWORD_DEFAULT);

        $query = "INSERT INTO people (FullName, LogonName, IsPermittedToLogon, HashedPassword, LastEditedBy) 
            VALUES('$FullName', '$EmailAddress', 'TRUE', '$password', 1)";
        $statement = mysqli_prepare($connectie, $query);
        mysqli_stmt_execute($statement);

        echo "<br> U bent geregistreerd";

        //       mysqli_query($connectie, $query);

        $_SESSION['username'] = $FullName;
        $_SESSION['success'] = "You are now logged in";

        // header('location: index.php');
    }
}
?>