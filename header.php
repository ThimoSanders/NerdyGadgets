<?php
session_start();
include "connect.php";

$Query = "SELECT StockGroupID, StockGroupName, ImagePath
            FROM stockgroups
            WHERE StockGroupID IN (
                SELECT StockGroupID
                FROM stockitemstockgroups
            ) AND ImagePath IS NOT NULL
            ORDER BY StockGroupID ASC";
$Statement = mysqli_prepare($Connection, $Query);
mysqli_stmt_execute($Statement);
$HeaderStockGroups = mysqli_stmt_get_result($Statement);
?>
<!DOCTYPE html>
<html lang="en" style="background-color: rgb(35, 35, 47);">
<head>
    <script src="Public/JS/fontawesome.js" crossorigin="anonymous"></script>
    <script src="Public/JS/jquery.min.js"></script>
    <script src="Public/JS/popper.min.js"></script>
    <script src="Public/JS/bootstrap.min.js"></script>
    <!--    <script src="Public/JS/Resizer.js"></script>-->
    <script src="Public/JS/jquery-3.4.1.js"></script>
    <style>
        @font-face {
            font-family: MmrText;
            src: url(/Public/fonts/mmrtext.ttf);
        }
    </style>
    <meta charset="ISO-8859-1">
    <title>NerdyGadgets</title>
    <link rel="stylesheet" href="Public/CSS/Style.css" type="text/css">
    <link rel="stylesheet" href="Public/CSS/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="Public/CSS/nha3fuq.css">
    <link rel="stylesheet" type="text/css" href="Public/CSS/style_betalingspagina.css">

    <link rel="apple-touch-icon" sizes="57x57" href="Public/Favicon/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="Public/Favicon/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="Public/Favicon/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="Public/Favicon/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="Public/Favicon/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="Public/Favicon/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="Public/Favicon/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="Public/Favicon/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="Public/Favicon/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192" href="Public/Favicon/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="Public/Favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="Public/Favicon/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="Public/Favicon/favicon-16x16.png">
    <link rel="manifest" href="Public/Favicon/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="Public/Favicon/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light nav-fill w-100" style="font-weight: bold">
    <div class="container-fluid p-0">
        <a class="navbar-brand" href="./">
            <div id="LogoImage"></div>
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownCategory" role="button"
                       data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Categorieën
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownCategory">
                        <?php
                        foreach ($HeaderStockGroups as $HeaderStockGroup) {
                            ?>
                            <a class="dropdown-item"
                               href="browse.php?category_id=<?= $HeaderStockGroup['StockGroupID'] ?>"><?= $HeaderStockGroup['StockGroupName'] ?></a>
                            <?php
                        }
                        ?>
                        <a href="categories.php" class="dropdown-item">Alle Categorieën</a>
                    </div>
                </li>
                <li class="nav-item">
                    <a href="browse.php" class="nav-link"><i class="fas fa-search" style="color:#676EFF;"></i>
                        Zoeken</a>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a href="shoppingcart.php">
                        <i class="fas fa-shopping-cart shopping_cart_icon" style="color:#676EFF;"></i>
                        <div class="badge badge-danger" id="shoppingcartAmount">
                            <?php
                            isset($_SESSION['shoppingcart_amount']) ? print $_SESSION['shoppingcart_amount'] : print 0;
                            ?>
                        </div>
                    </a>
                </li>
                <?php
                if (isset($_SESSION['login'])) {
                    ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownAccount" role="button"
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <?= $_SESSION["login"]["FullName"] ?>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdownAccount">
                            <a class="dropdown-item" href="Uitloggen.php">Uitloggen</a>
                        </div>
                    </li>
                    <?php
                } else {
                    ?>
                    <li class="nav-item">
                        <a href="login.php" class="nav-link"><i style="color:#676EFF;"></i> Inloggen <i class="fas fa-user-circle"></i></a>
                    </li>
                    <?php
                }
                ?>
            </ul>
        </div>
    </div>
</nav>
<div class="container">
    <div class="row" id="Content">
        <div class="col-12">
            <div id="SubContent">


