<?php
include __DIR__ . "/header.php";
?>
<div class="col-12">
    <div class="shoppingheader"
    <header>
        <br>
        <h1>winkelwagen</h1>
    </header>
<?php
$totalPrice = 0;
if (!isset($_SESSION['shoppingcart'])) {
    print "<h1>Er zit niks in je winkelwagen</h1>";
} else {
    //foreach loop for every item in the shopping cart
    foreach ($_SESSION['shoppingcart'] as $key => $value) {
        //prints the key, in this case the "StockItemID"
        print("key: ".$key);
        //prints the value, in this case the quantity
        print(" value: ".$value);
        //prints <br>... duh
        print("<br>");
    }

    $productID = 96;

    $Connection = mysqli_connect("localhost", "root", "", "nerdygadgets", "3306");
    $Query = "SELECT ImagePath
              FROM stockitemimages 
              WHERE StockItemID = ?";
    $Statement = mysqli_prepare($Connection, $Query);
    mysqli_stmt_bind_param($Statement, "i", $productID);
    mysqli_stmt_execute($Statement);
    $R = mysqli_stmt_get_result($Statement);
    $R = mysqli_fetch_all($R, MYSQLI_ASSOC);

    $Query = "SELECT StockItemName, RecommendedRetailPrice
            FROM stockitems
            WHERE StockItemID = ?";
    $Statement = mysqli_prepare($Connection, $Query);
    mysqli_stmt_bind_param($Statement, "i", $productID);
    mysqli_stmt_execute($Statement);
    $N = mysqli_stmt_get_result($Statement);
    $N = mysqli_fetch_all($N, MYSQLI_ASSOC);
?>
    <div id="ImageFrame"
         style="background-image: url('Public/StockItemIMG/<?php print $R[0]['ImagePath']; ?>'); background-size: 300px; background-repeat: no-repeat; background-position: center;">
    </div>
    <h2><?=$N[0]['StockItemName']?></h2>
    <h5><?=$N[0]['RecommendedRetailPrice']?></h5>

    <h3>totaalprijs: <?=$totalPrice?></h3>
</div>
<?php
}
?>




