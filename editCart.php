<?php
session_start();
try {
    $ItemID = $_GET['ItemID'];
    $Quantity = $_GET['Quantity'];
    $Price = $_GET['Price'];
    $TotalPrice = $_GET['TotalPrice'];

    if (!isset($_SESSION['shoppingcart'])) {
        throw new Exception("No session");
    }
    if (!array_key_exists( $ItemID, $_SESSION['shoppingcart'])) {
        throw new Exception("ItemID not in shoppingcart");
    }
    if ($Quantity < 0 || !is_numeric($Quantity)) {
        throw new Exception("Invalid quantity");
    }
    if ($Quantity == 0) {
        unset($_SESSION['shoppingcart'][$ItemID]);
        if (count($_SESSION['shoppingcart']) == 0) {
            unset($_SESSION['shoppingcart']);
            $_SESSION['totalPrice'] = 0;
        }
    } else {
        $_SESSION['shoppingcart'][$ItemID] = $Quantity;
        $_SESSION['totalPrice'] = $Price * $Quantity + $TotalPrice;
    }

    $totalAmount = 0;
    foreach ($_SESSION['shoppingcart'] as $value) {
        $totalAmount += $value;
    }
    $_SESSION['shoppingcart_amount'] = $totalAmount;

    echo json_encode(["message" => "success", "totalAmount" => $totalAmount]);
} catch (Exception $e) {
    echo json_encode(["error" => $e->getMessage()]);
}