<?php
include __DIR__ . "/header.php";
include __DIR__ . "/connect.php";
?>
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
                    <input type="text" name="username" value="<?php if(isset($_POST['reg_user'])){
                        echo $_POST['username'];} ?>" placeholder="Naam" required value="">
                </div>
                    <label>Email:</label>
                <div class="textbox">
                    <input type="email" name="email" value="<?php if(isset($_POST['reg_user'])){
                        echo $_POST['email'];} ?>" placeholder="Email" required value="">
                </div>
                    <label>Wachtwoord:</label>
                <div class="textbox">
                    <input type="password" name="password_1" placeholder="Wachtwoord">
                    <p style="font-size: small; color: black">Minimaal: 8 tekens, 1 hoofdletter, 2 cijfers, 1 leesteken.</p>
                </div>
                    <label>Bevestig wachtwoord:</label>
                <div class="textbox">
                    <input type="password" name="password_2" placeholder="Wachtwoord">
                </div>
                <label>Land:</label>
                <div class="textbox">
                    <input type="Land" name="country" value="<?php if(isset($_POST['reg_user'])){
                        echo $_POST['country'];} ?>" placeholder="Land" required value="">
                </div>
                <label>Adres:</label>
                <div class="textbox">
                    <input type="Address" name="address" value="<?php if(isset($_POST['reg_user'])){
                        echo $_POST['address'];} ?>" placeholder="Adres" required value="">
                </div>
                <label>Postcode:</label>
                <div class="textbox">
                    <input type="Postalcode" name="postalcode" value="<?php if(isset($_POST['reg_user'])){
                        echo $_POST['postalcode'];} ?>" placeholder="Postcode" required value="">
                </div>
                <input type="submit" name="reg_user" value="Registreren" />
        </form>
        </div>
    <h4>Heb je al een account? <a href="login.php">Inloggen</a><br>

    </body>
    </html>

<?php
$FullName = "";
$EmailAddress = "";
$errors = FALSE;

//$host = "localhost";
//$databasename = "nerdygadgets";
//$user = "root";
//$pass = "";
//$port = 3306;
//$connectie = mysqli_connect($host, $user, $pass, $databasename, $port);

$sql = "SELECT * FROM people";
$result = mysqli_query($Connection, $sql);
$people = mysqli_fetch_all($result,MYSQLI_ASSOC);

if (isset($_POST['reg_user'])) {
    $FullName = mysqli_real_escape_string($Connection, $_POST['username']);
    $EmailAddress = mysqli_real_escape_string($Connection, $_POST['email']);
    $password_1 = mysqli_real_escape_string($Connection, $_POST['password_1']);
    $password_2 = mysqli_real_escape_string($Connection, $_POST['password_2']);
    $Country = mysqli_real_escape_string($Connection, $_POST['country']);
    $Address = mysqli_real_escape_string($Connection, $_POST['address']);
    $Postalcode = mysqli_real_escape_string($Connection, $_POST['postalcode']);

    if (empty($FullName)) {
        $errors = TRUE;
    }
    if (empty($EmailAddress)) {
        $errors = TRUE;
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
        print("<br> Het wachtwoord voldoet niet aan de eisen!");
    }

    if ($password_1 != $password_2) {
        $errors = TRUE;
        echo "<br> De twee wachtwoorden komen niet overheen. ";
    }
    if (empty($Country)) {
        $errors = TRUE;
    }
    if (empty($Address)) {
        $errors = TRUE;
    }
    if (empty($Postalcode)) {
        $errors = TRUE;
    }

// a user does not already exist with the same username and/or email
    $user_check_query = "SELECT * FROM people WHERE LogonName='$EmailAddress' LIMIT 1";
    $result = mysqli_query($Connection, $user_check_query);
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
        $statement = mysqli_prepare($Connection, $query);
        mysqli_stmt_bind_param($statement, "ssssss", $FullName, $EmailAddress, $password, $Country, $Address, $Postalcode);
        mysqli_stmt_execute($statement);

        ?>
        <script>
            window.location.href = "http://localhost/NerdyGadgets/?message=register_success";
        </script>
        <?php
        $_SESSION['username'] = $FullName;
        $_SESSION["login"] = ["PersonID"=> $people[0]["PersonID"], "FullName"=> $FullName, "LogonName"=>$EmailAddress, "Country" => $Country, "Address" => $Address, "PostalCode" => $Postalcode];
    }
}
?>