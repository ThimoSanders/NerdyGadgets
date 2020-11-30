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
                <label>Land:</label>
                <div class="textbox">
                    <input type="Land" name="country" placeholder="Land">
                </div>
                <label>Adres:</label>
                <div class="textbox">
                    <input type="Address" name="address" placeholder="Adres">
                </div>
                <label>Postcode:</label>
                <div class="textbox">
                    <input type="Postalcode" name="postalcode" placeholder="Postcode">
                </div>

                <input type="submit" name="reg_user" value="Registreren" />
        </form>
        </div>
    <h4>Al een Lid? <a href="login.php">Inloggen</a><br>

    </body>
    </html>

<?php
$FullName = "";
$EmailAddress = "";
$errors = FALSE;

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
    $Country = mysqli_real_escape_string($connectie, $_POST['country']);
    $Address = mysqli_real_escape_string($connectie, $_POST['address']);
    $Postalcode = mysqli_real_escape_string($connectie, $_POST['postalcode']);

    if (empty($FullName)) {
        $errors = TRUE;
        echo "<br> Naam is niet ingevuld. ";
    }
    if (empty($EmailAddress)) {
        $errors = TRUE;
        echo "<br> Email is niet ingevuld. ";
    }
    if (empty($password_1)) {
        $errors = TRUE;
        echo "<br> Wachtwoord is niet ingevuld. ";
    }
    $hoofdletter = preg_match('@[A-Z]@', $password_1);
    $kleineletter = preg_match('@[a-z]@', $password_1);
    $nummer = preg_match('@[0-9]{2,}@', $password_1);
    $karater = preg_match('@[^\w]@', $password_1);

    if(!$hoofdletter || !$kleineletter || !$nummer || !$karater || strlen($password_1) < 8) {
        $errors = TRUE;
        print("Het wachtwoord voldoet niet aan de eisen!");
    }
    else {
        print("Het werkt");
    }

    if ($password_1 != $password_2) {
        $errors = TRUE;
        echo "<br> De twee wachtwoorden komen niet overheen. ";
    }
    if (empty($Country)) {
        $errors = TRUE;
        echo "<br> Land is niet ingevuld. ";
    }
    if (empty($Address)) {
        $errors = TRUE;
        echo "<br> Adres is niet ingevuld. ";
    }
    if (empty($Postalcode)) {
        $errors = TRUE;
        echo "<br> Postcode is niet ingevuld. ";
    }

// a user does not already exist with the same username and/or email
    $user_check_query = "SELECT * FROM people WHERE FullName='$FullName' OR EmailAddress='$EmailAddress' LIMIT 1";
    $result = mysqli_query($connectie, $user_check_query);
    $user = mysqli_fetch_assoc($result);

// if Email already exists
    if ($user) {
        if ($user['LogonName'] === $EmailAddress) {
            $errors = TRUE;
            echo "<br> Email is al in gebruik. ";
        }
    }
// register user if there are no errors
    if ($errors == FALSE) {
        $password = password_hash($password_1, PASSWORD_DEFAULT);

        $query = "INSERT INTO people (FullName, LogonName, HashedPassword, Country, Address, Postalcode, IsPermittedToLogon, LastEditedBy) 
            VALUES( ?, ?, ?, ?, ?, ?, 'TRUE', 1)";
        $statement = mysqli_prepare($connectie, $query);
        mysqli_stmt_bind_param($statement, "ssssss", $FullName, $EmailAddress, $password, $Country, $Address, $Postalcode);
        mysqli_stmt_execute($statement);

        echo "<br> U bent geregistreerd. ";

        $_SESSION['username'] = $FullName;
        $_SESSION["login"] = ["FullName"=> $FullName, "LogonName"=>$EmailAddress, "Country" => $Country, "Address" => $Address, "PostalCode" => $Postalcode];

    }
}
?>