<?php
session_start();
if (!isset($_POST['submitted'])) {
    header('Location: '.$_SERVER['HTTP_REFERER']);
    exit();
}
try {
    $id = $_POST['StockItemID'];
    $quatity = $_POST['quantity'];

    if (!isset($_SESSION['shoppingcart'])) {
        $_SESSION['shoppingcart'] = [];
    }

    if (array_key_exists($id, $_SESSION['shoppingcart'])) {
        $_SESSION['shoppingcart'][$_POST['StockItemID']] += $_POST['quantity'];
    } else {
        $_SESSION['shoppingcart'][$_POST['StockItemID']] = $_POST['quantity'];
    }

    header('Location: '.$_SERVER['HTTP_REFERER']."&success=1");
    exit();
} catch (Exception $exception) {
    header('Location: '.$_SERVER['HTTP_REFERER']."&success=0");
    exit();
}

