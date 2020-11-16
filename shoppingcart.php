<?php

include __DIR__ . "/header.php";

?>


<section class="mid-wrapper">
    <h1>
        winkelwagen
    </h1>

    <?php
    $totalPrice = 0;
    if (!isset($_SESSION['shoppingcart'])) {
        print "<h1>Er zit niks in je winkelwagen</h1>";
    } else {
        //foreach loop for every item in the shopping cart
        foreach ($_SESSION['shoppingcart'] as $productID => $value) {
            //prints the key, in this case the "StockItemID"

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
            $totalPrice += $N[0]['RecommendedRetailPrice'] * $value;
            ?>

            <div id="item">

                <!--        <span class="i" id="image"></span>-->
                <div class="i" id="image"
                     style="background-image: url('Public/StockItemIMG/<?php print $R[0]['ImagePath']; ?>'); background-size: 60px; background-repeat: no-repeat; background-position: center;">
                </div>
                <div class="c-content">
                    <span class="i" id="title">artikelnummer: <?= $productID?></span>
                    <span class="i" id="subtitle"><?=$N[0]['StockItemName']?></span>
                </div>
                <div class="amount">
                    <span id="title">Aantal:&nbsp;</span>
                    <div class="ticker">
<!--                        <span id="up">&#8679;</span>-->
<!--                        <span id="amount">--><?//= $value?><!--</span>-->
<!--                        <span id="down">&#8681;</span>-->
                        <input type="number" min="0" max="">
                    </div>
                </div>
                <div class="price">
                    <span id="value">&euro; <?=$N[0]['RecommendedRetailPrice'] * $value?></span>
                </div>
            </div>

            <?php
        }
        $_SESSION['totalPrice'] = $totalPrice;
    }
    ?>
    <hr style="border-color: #000;margin-top: 70px">

    <div class="__q98">
        <span class="i" id="shipping">Verzendkosten: &euro;3,50</span>
        <span class="i" id="total">Totaal: &euro;<?= $totalPrice?></span>

        <a href="checkout.php">
            <button class="i" id="Pay">Afrekenen</button>
        </a>
    </div>

</section>
<script>

</script>

<style type="text/css">
    body, html {
        margin: 0;
        padding: 0;
        font-family: "Arial";
    }

    #nav {
        display: block;
        margin: auto;
        left: 0;
        right: 0;
        background: #FFF;
        padding: 30px 0;
        border: 2px solid #000;
    }
    #nav > #title {
        text-transform: uppercase;
        text-align: center;
        left: 0;
        right: 0;
        margin: auto;
        display: block;
        font-size: 30px;
    }

    .mid-wrapper {
        width: calc(100% - 500px);
        left: 0;
        right: 0;
        margin: auto;
        position: relative;
        margin-top: 50px;
        display: block;
    }

    .mid-wrapper > #item {
        padding: 20px;
        border: 2px solid #000;
        margin: 25px 0;
        position: relative;
    }
    .mid-wrapper > #item > #image {
        --size: 60px;
        position: absolute;
        display: block;
        border: 2px solid #000;
        width: var(--size);
        height: var(--size);
        top: 50%;
        left: 20px;
        transform: translateY(-50%);
    }
    .mid-wrapper > #item > .c-content {
        margin-left: 80px;
        display: block;
    }
    .mid-wrapper > #item > .c-content > .i {
        display: block;
        padding: 5px 0;
    }
    .mid-wrapper > #item > .c-content > span:nth-child(1) {
        font-size: 15px;
    }
    .mid-wrapper > #item > .c-content > span:nth-child(2) {
        font-size: 20px;
    }



    .mid-wrapper > #item > .amount {
        position: absolute;
        left: 0;
        right: 0;
        margin: auto;
        display: block;
        width: 100px;
        top: 50%;
        transform: translateY(-50%);
    }

    .mid-wrapper > #item > .amount > #title {

    }
    .mid-wrapper > #item > .amount > .ticker {
        position: absolute;
        width: 35px;
        height: 60px;
        display: block;
        margin-top: -40px;
        margin-left: 60px;
        border: 2px solid #000;
    }
    .mid-wrapper > #item > .amount > .ticker > #up,
    .mid-wrapper > #item > .amount > .ticker > #amount,
    .mid-wrapper > #item > .amount > .ticker > #down {
        text-align: center;
        display: block;
    }


    .mid-wrapper > #item > .price {
        position: absolute;
        right: 20px;
        top: 50%;
        transform: translateY(-50%);
        font-size: 25px;
    }

    .mid-wrapper > .__q98 {
        position: absolute;
        right: 0;
        margin-top: 50px;
        text-align: right;
    }

    .mid-wrapper > .__q98 > .i {
        display: block;
        padding: 5px 0;
    }

    .mid-wrapper > .__q98 > #pay {
        margin-top: 50px;
        border: 2px solid #000;
        padding: 10px 40px;
        font-size: 18px;
        background: #FFF;
    }


</style>

