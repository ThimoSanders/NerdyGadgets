<?php

$FullName = "";
$EmailAddress    = "";
$errors = array();

// connect to the database
$host = "localhost";
$databasename = "nerdygadgets";
$user = "root";
$pass = "";
$port = 3306;
$connectie = mysqli_connect($host, $user, $pass, $databasename, $port);

$sql = "SELECT * FROM people";
$result = mysqli_query($connectie, $sql);
$people = mysqli_fetch_all($result,MYSQLI_ASSOC);

// REGISTER USER
if (isset($_POST['reg_user'])) {
    $FullName = mysqli_real_escape_string($connectie, $_POST['username']);
    $EmailAddress = mysqli_real_escape_string($connectie, $_POST['email']);
    $password_1 = mysqli_real_escape_string($connectie, $_POST['password_1']);
    $password_2 = mysqli_real_escape_string($connectie, $_POST['password_2']);

    if (empty($FullName)) { array_push($errors, "Username is required");
        echo "<br> Naam is niet ingevuld " ; }
    if (empty($EmailAddress)) { array_push($errors, "Email is required");
        echo "<br> Email is niet ingevuld "; }
    if (empty($password_1)) { array_push($errors, "Password is required");
        echo "<br> Wachtwoord is niet ingevuld "; }
    if ($password_1 != $password_2) {
        array_push($errors, "The two passwords do not match");
        echo "<br> De twee wachtwoorden komen niet overheen"; }

    // a user does not already exist with the same username and/or email
    $user_check_query = "SELECT * FROM people WHERE FullName='$FullName' OR EmailAddress='$EmailAddress' LIMIT 1";
    $result = mysqli_query($connectie, $user_check_query);
    $user = mysqli_fetch_assoc($result);

    // if user exists
    if ($user) {
        if ($user['FullName'] === $FullName) {
            array_push($errors, "Username already exists");
            echo "<br> ";
        }

        if ($user['LogonName'] === $EmailAddress) {
            array_push($errors, "email already exists");
            echo "<br> Email is al in gebruik";
        }
    }

    // register user if there are no errors in the form
    if (count($errors) == 0) {
        $password = password_hash($password_1, PASSWORD_DEFAULT);

        $query = "INSERT INTO people (FullName, LogonName, IsPermittedToLogon, HashedPassword, LastEditedBy) 
  			  VALUES('$FullName', '$EmailAddress', 'TRUE', '$password', 1)";
 //       mysqli_query($connectie, $query);
        if($connectie->query($query) === TRUE){
            echo "top";
        } else {
            echo "niet top" . $connectie->error;
        }

        $_SESSION['username'] = $FullName;
        $_SESSION['success'] = "You are now logged in";
        // header('location: index.php');
    } else {
        echo "Niet top";
    }
}

?>