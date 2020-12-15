<?php

include __DIR__ . "/header.php";
include __DIR__ . "/connect.php";

?>

    <link rel="stylesheet" type="text/css" href="Public/CSS/Style.css">

    <h1>
        Geschiedenis
    </h1>

<?php
if (!isset($_SESSION['login'])) {
    ?>
    <h1>Je bent niet ingelogd!</h1>
    <?php
}
else {
    $personID = $_SESSION["login"]["PersonID"];

    print("<br><br>");

//VERBINDING MAKEN - Hier geef je de rechten en de locatie waar de database staat.
    $host = "localhost";
    $databasename = "nerdygadgets";
    $user = "root";
    $pass = "";
    $port = 3306;
    $connection = mysqli_connect($host, $user, $pass, $databasename, $port);

//DB server ‘voorbereiden’ dat er SQL statement aankomt met parameter
    $statement = mysqli_prepare($connection, "SELECT OrdorID, Price, OrderDate FROM order2 WHERE PersonID IN (SELECT PersonID FROM people WHERE PersonID = ?)");

// ? koppelen aan variabele
    mysqli_stmt_bind_param($statement, 'i', $personID); // i = integer; s = string;

//query uitvoeren
    mysqli_stmt_execute($statement);

//resultaat ophalen
    $result = mysqli_stmt_get_result($statement);

//RESULTAAT UITLEZEN - fetch alle gegevens in een associative array $medewerkers
    $orders = mysqli_fetch_all($result, MYSQLI_ASSOC);
}









if (!isset($_SESSION['login'])) {
    print("");
} else {
    if(count($orders) == 0) {
        print("U heeft nog geen bestellingen.");
    }
    else {?>
        <div class='h-item'>
        <?php
        foreach ($orders AS $ordernummer) {
            ?>
                <div class="row h-items">
                    <div class='col-6'>
                        <?php
                        $order = $ordernummer['OrdorID'];
                        ?><b>Ordernummer:</b> <?php print($order);
                        print("<br>");
                        ?><b>Datum:</b> <?php print(date("d-m-Y H:i", strtotime($ordernummer['OrderDate'])));
                        print("<br>");
                        ?><b>Prijs:</b> €<?php print str_replace(".",",", $ordernummer['Price']);
                        print("<br>");

                        ?>
                    </div>
                    <div class="col-6" >
                        <?php
                        $statement1 = mysqli_prepare($connection, "SELECT StockItemName FROM stockitems WHERE StockItemID IN (SELECT StockItemID FROM orderlines WHERE OrderID = ?) ");
                        mysqli_stmt_bind_param($statement1, 'i', $order);
                        mysqli_stmt_execute($statement1);
                        $result = mysqli_stmt_get_result($statement1);
                        $items = mysqli_fetch_all($result,MYSQLI_ASSOC);
                        ?><b>Producten:<br></b> <?php
                        foreach($items AS $nummeritem) {
                            print($nummeritem["StockItemName"] . "<br>");
                        }
                        ?>
                    </div>
                </div>
            <?php
        }
        ?>
        </div>
        <?php
    }
}



