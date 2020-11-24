<?php
include __DIR__ . "/header.php";

unset(($_SESSION)["login"]);

?>

<!DOCTYPE html>
<html>
<head>

    <link rel="stylesheet" type="text/css" href="Public/CSS/style_betalingspagina.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <div class="z">
        <label>U bent uitgelogd</label>
    </div>
    <div class="z2">
        <a href="login.php" class="HrefDecoration"><i style="color:#676EFF;"></i>Als u hierop klikt kunt u weer inloggen.</a>
    </div>

</head>
<body>