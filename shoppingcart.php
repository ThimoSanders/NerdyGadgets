<?php
include __DIR__ . "/header.php";
?>
<div class="col=58">
    <div class="shoppingheader"
    <header>
        <br>
        <h1>winkelwagen</h1>
    </header>
</div>
</div>
<?php
$shoppingcart =
    [93 => 2, 138 => 1];
$productID = 93;
$Connection = mysqli_connect("localhost", "root", "", "nerdygadgets", "3306");
$Query = "
                SELECT ImagePath
                FROM stockitemimages 
                WHERE StockItemID = ?";
$Statement = mysqli_prepare($Connection, $Query);
mysqli_stmt_bind_param($Statement, "i", $productID);
mysqli_stmt_execute($Statement);
$R = mysqli_stmt_get_result($Statement);
$R = mysqli_fetch_all($R, MYSQLI_ASSOC);


?>
<div id="ImageFrame"
     style="background-image: url('Public/StockItemIMG/<?php print $R[0]['ImagePath']; ?>'); background-size: 300px; background-repeat: no-repeat; background-position: center;"></div>

<?php
 $Query = "
                   SELECT StockItemName, RecommendedRetailPrice
                   FROM stockitems
                   WHERE StockItemID = ?";
$Statement = mysqli_prepare($Connection, $Query);
mysqli_stmt_bind_param($Statement, "i", $productID);
mysqli_stmt_execute($Statement);
$N = mysqli_stmt_get_result($Statement);
$N = mysqli_fetch_all($N, MYSQLI_ASSOC);

print $N[0]['StockItemName']; ?>
<br>
<?php print $N[0]['RecommendedRetailPrice']; ?>
<br>



<?php print ("totaalprijs :"); ?>






