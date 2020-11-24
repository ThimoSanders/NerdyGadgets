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

            $Query = "SELECT SI.StockItemID, SI.StockItemName, SI.RecommendedRetailPrice, SIH.QuantityOnHand
            FROM stockitems AS SI JOIN stockitemholdings SIH ON SI.StockItemID = SIH.StockItemID WHERE SI.StockItemID = ?
            ";
            $Statement = mysqli_prepare($Connection, $Query);
            mysqli_stmt_bind_param($Statement, "i", $productID);
            mysqli_stmt_execute($Statement);
            $N = mysqli_stmt_get_result($Statement);
            $N = mysqli_fetch_all($N, MYSQLI_ASSOC);
            $totalPrice += $N[0]['RecommendedRetailPrice'] * $value;
            ?>

            <div
                    class="CartItem"
                    id="item"
                    data-price="<?=$N[0]['RecommendedRetailPrice']?>"
                    data-id="<?=$productID?>"
                    data-totalprice="<?=$N[0]['RecommendedRetailPrice'] * $value?>"
            >

                <!--        <span class="i" id="image"></span>-->
                <div class="i" id="image"
                     style="background-image: url('Public/StockItemIMG/<?php print $R[0]['ImagePath']; ?>'); background-size: 60px; background-repeat: no-repeat; background-position: center;">
                </div>
                <div class="c-content">
                    <span class="i" id="title">artikelnummer: <?= $productID ?></span>
                    <span class="i" id="subtitle"><?= $N[0]['StockItemName'] ?></span>
                </div>
                <div class="amount" data-itemid="<?=$productID?>">
                    <span id="title">Aantal:&nbsp;</span>
                    <div class="ticker">
                        <input
                                class="ShoppingQuantity"
                                type="number"
                                min="0" max="<?=$N[0]['QuantityOnHand']?>"
                                value="<?=$value?>"
                        >
                    </div>
                    <button class="btn btn-outline-danger" onclick="removeItem()">
                        <i class="far fa-trash-alt"></i>
                    </button>
                </div>
                <div class="price">
                    <span class="CartItemPrice" id="value">
                        &euro;<?=$N[0]['RecommendedRetailPrice'] * $value?>
                    </span>
                </div>
            </div>

            <?php
        }
        $_SESSION['totalPrice'] = $totalPrice;
    }
    ?>
    <hr style="border-color: #000;margin-top: 70px">

    <div class="__q98">
        <!--        <span class="i" id="shipping">Verzendkosten: &euro;3,50</span>-->
        <span class="i" id="total">Totaal: &euro;<?=$totalPrice?></span>
        <a href="checkout.php">
            <button class="i" id="Pay">Afrekenen</button>
        </a>
    </div>

</section>
<script>
    function removeItem() {
        updateShoppingCart(this.event, true);
    }
    function calculateTotalPrice(element) {
        let total = 0;
        if (element) {
            $(".CartItem").each(index => {
                let el = $($(".CartItem")[index]);
                if (el.data('id') != element.data('id')) {
                    total += parseFloat($(el).data('totalprice'));
                }
            });
        } else {
            $(".CartItem").each(index => {
                let el = $($(".CartItem")[index]);
                total += parseFloat($(el).data('totalprice'));
            });
        }

        return total;
    }
    function updateShoppingCart(e, remove) {
        let target = $(e.target);
        let element = target.closest(".CartItem");
        let ItemID = target.closest(".amount").data('itemid');
        let quantity = remove ? 0 : e.target.value;
        let price = element.data('price');
        let priceElement = element.find('.CartItemPrice');

        let url = "<?=$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF'])?>";
        fetch('http://'+url+`/editCart.php?ItemID=${ItemID}&Quantity=${quantity}&Price=${price}&TotalPrice=${calculateTotalPrice(element)}`)
            .then(res => res.json())
            .then(res => {
                if (res.error) {
                    console.warn(res.error);
                } else if(res.message === "success") {
                    if (quantity == 0) {
                        element.remove();
                    } else {
                        let value = (price * quantity).toFixed(2);
                        element.data('totalprice', value);
                        priceElement.text('€'+ value);
                    }
                    $("#shoppingcartAmount").text(res.totalAmount);
                    $("#total").text('Totaal: €'+calculateTotalPrice().toFixed(2));
                }
            });
    }
    $(".ShoppingQuantity").change((e) => {
        updateShoppingCart(e);
    });
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

    .mid-wrapper > #item > .amount > button {
        color: #F54052;
        position: absolute;
        margin-top: -10px;
        margin-left: 100px;
    }
    .mid-wrapper > #item > .amount > button:hover {
        color:white;
    }

    .mid-wrapper > #item > .amount > .ticker {
        position: absolute;
        width: 75px;
        height: 60px;
        display: block;
        margin-top: -40px;
        margin-left: 60px;
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

