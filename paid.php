<?php
include __DIR__ . "/header.php";
?>

    <div class="z">
        <label>Bedankt voor uw bestelling!</label>
    </div>
    <div class="z2"
         <label>Uw bestelling is geplaatst en wordt momenteel verwerkt. U zal een email ontvangen met de details van de bestelling.</label>
    </div>

<?php

if (isset($_POST["knop"])) {
    $FullName= $_POST["vnaam"];
    $Country= $_POST["land"];
    $Address= $_POST["straat"];
    $Postalcode= $_POST["postcode"];
    $LogonName= $_POST["email"];
    $Price= $_SESSION["totalPrice"];

    foreach ($_SESSION['shoppingcart'] as $productID => $value) {
        $Connection = mysqli_connect("localhost", "root", "", "nerdygadgets", "3306");
        $Query= "UPDATE stockitemholdings 
         SET QuantityOnHand = QuantityOnHand - ?  
         WHERE StockItemID = ?";
        $statement = mysqli_prepare($Connection, $Query);
        mysqli_stmt_bind_param($statement, "ii", $value, $productID);
        mysqli_stmt_execute($statement);
    }

    $Query2= "INSERT INTO order2 (FullName, Country, Address, Postalcode, LogonName, Price)
          VALUES (?, ?, ?, ?, ?, ?)";
    $statement2 = mysqli_prepare($Connection, $Query2);
    mysqli_stmt_bind_param($statement2, "sssssd", $FullName, $Country, $Address, $Postalcode, $LogonName, $Price);
    mysqli_stmt_execute($statement2);
}

include "footer.php";
?>
