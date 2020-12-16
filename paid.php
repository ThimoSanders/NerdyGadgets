<?php
include __DIR__ . "/header.php";
include __DIR__ . "/connect.php";
?>

    <div class="z">
        <label>Bedankt voor uw bestelling!</label>
    </div>
    <div class="z2"
         <label>Uw bestelling is geplaatst en wordt momenteel verwerkt. U zal een email ontvangen met de details van de bestelling.</label>
    </div>

<?php

if (isset($_POST["knop"])) {
    $FullName = $_POST["vnaam"];
    $Country = $_POST["land"];
    $Address = $_POST["straat"];
    $Postalcode = $_POST["postcode"];
    $LogonName = $_POST["email"];
    $Price = $_SESSION["totalPrice"];
    if (isset ($_SESSION["login"])) {
        $PersonID = $_SESSION["login"]["PersonID"];
    }
    else { $personID = NULL;
    }


    $Connection->autocommit(false);


    $Query2 = "INSERT INTO order2 (PersonID, FullName, Country, Address, Postalcode, LogonName, Price)
          VALUES (?, ?, ?, ?, ?, ?, ?)";
    $statement2 = mysqli_prepare($Connection, $Query2);
    mysqli_stmt_bind_param($statement2, "isssssd", $PersonID, $FullName, $Country, $Address, $Postalcode, $LogonName, $Price);
    mysqli_stmt_execute($statement2);
    $order_id = $statement2->insert_id;


    foreach ($_SESSION['shoppingcart'] as $productID => $value) {
        $Query = "UPDATE stockitemholdings
         SET QuantityOnHand = QuantityOnHand - ?
         WHERE StockItemID = ?";
        $statement = mysqli_prepare($Connection, $Query);
        mysqli_stmt_bind_param($statement, "ii", $value, $productID);
        mysqli_stmt_execute($statement);
    }

    foreach ($_SESSION['shoppingcart'] as $productID => $value) {
        $Query = "INSERT INTO orderlines
         (OrderID, StockItemID, PackageTypeID, Quantity, LastEditedBy)
         VALUES (?,?,7,?,4)";
        $statement = mysqli_prepare($Connection, $Query);
        mysqli_stmt_bind_param($statement, "iii", $order_id, $productID, $value);
        mysqli_stmt_execute($statement);
    }
    $Connection->commit();
}


include "footer.php";
?>
