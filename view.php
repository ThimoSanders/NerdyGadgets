<?php
$Connection = mysqli_connect("localhost", "root", "", "nerdygadgets");
mysqli_set_charset($Connection, 'latin1');
include __DIR__ . "/header.php";

$Query = " 
           SELECT SI.StockItemID, 
            (RecommendedRetailPrice*(1+(TaxRate/100))) AS SellPrice, 
            StockItemName,QuantityOnHand,
            SearchDetails, IsChillerStock, ChillerStockRoom,
            (CASE WHEN (RecommendedRetailPrice*(1+(TaxRate/100))) > 50 THEN 0 ELSE 6.95 END) AS SendCosts, MarketingComments, CustomFields, SI.Video,
            (SELECT ImagePath FROM stockgroups JOIN stockitemstockgroups USING(StockGroupID) WHERE StockItemID = SI.StockItemID LIMIT 1) as BackupImagePath   
            FROM stockitems SI 
            JOIN stockitemholdings SIH USING(stockitemid)
            JOIN stockitemstockgroups ON SI.StockItemID = stockitemstockgroups.StockItemID
            JOIN stockgroups USING(StockGroupID)
            WHERE SI.stockitemid = ?
            GROUP BY StockItemID";

$ShowStockLevel = 1000;
$Statement = mysqli_prepare($Connection, $Query);
mysqli_stmt_bind_param($Statement, "i", $_GET['id']);
mysqli_stmt_execute($Statement);
$ReturnableResult = mysqli_stmt_get_result($Statement);
if ($ReturnableResult && mysqli_num_rows($ReturnableResult) == 1) {
    $Result = mysqli_fetch_all($ReturnableResult, MYSQLI_ASSOC)[0];
    if ($Result['IsChillerStock'] && isset($Result['ChillerStockRoom'])) {
        $Query = "SELECT Temperature FROM coldroomtemperatures WHERE ColdRoomSensorNumber = ? ORDER BY ValidFrom";
        $Statement = mysqli_prepare($Connection, $Query);
        mysqli_stmt_bind_param($Statement, "i", $Result['ChillerStockRoom']);
        mysqli_stmt_execute($Statement);
        $Temp = mysqli_stmt_get_result($Statement);
        $Temp = mysqli_fetch_all($Temp, MYSQLI_ASSOC)[0];
    }
} else {
    $Result = null;
}
//Get Images
$Query = "
                SELECT ImagePath
                FROM stockitemimages 
                WHERE StockItemID = ?";

$Statement = mysqli_prepare($Connection, $Query);
mysqli_stmt_bind_param($Statement, "i", $_GET['id']);
mysqli_stmt_execute($Statement);
$R = mysqli_stmt_get_result($Statement);
$R = mysqli_fetch_all($R, MYSQLI_ASSOC);

if ($R) {
    $Images = $R;
}
?>
<!--<div class="container">-->
    <?php
    if (isset($_GET['success'])) {
        if ($_GET['success']) {
            ?>
            <div class="alert alert-success">Het product is toegevoegd!</div>
        <?php } else { ?>
            <div class="alert alert-danger">Er is iets fout gegaan tijdens het toevoegen, probeer het later nog eens.
            </div>
        <?php }
    }
    if ($Result != null) {
        ?>
        <div class="row mt-2 StockItemDescriptionBox p-3">
            <div class="col-lg-4">
                <?php
                if (isset($Images)) {
                    // print Single
                    if (count($Images) == 1) {
                        ?>
                        <img class="w-100" src="Public/StockItemIMG/<?= $Images[0]['ImagePath']; ?>"/>
                        <?php
                    } else if (count($Images) >= 2) { ?>
<!--                            TODO: fix height images, set some sort of fixed height -->
                        <div id="carouselExampleIndicators" class="carousel slide">
                            <ol class="carousel-indicators">
                                <?php
                                for ($i = 0; $i < count($Images); $i++) {
                                    ?>
                                    <li data-target="#carouselExampleIndicators" data-slide-to="<?= $i ?>"
                                        class="<?php print ($i == 0) ? 'active' : ''; ?>"></li>
                                    <?php
                                }
                                ?>
                            </ol>
                            <div class="carousel-inner">
                                <?php
                                for ($i = 0; $i < count($Images); $i++) {
                                    ?>
                                    <div class="carousel-item <?php print ($i == 0) ? 'active' : ''; ?>">
                                        <img class="d-block carouselImage"
                                             src="Public/StockItemIMG/<?= $Images[$i]['ImagePath'] ?>"
                                             alt="First slide">
                                    </div>
                                    <?php
                                }
                                ?>
                            </div>
                            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button"
                               data-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="sr-only">Previous</span>
                            </a>
                            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button"
                               data-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="sr-only">Next</span>
                            </a>
                        </div>
                        <?php
                    }
                } else {
                    ?>
                    <img class="w-100" src="Public/StockGroupIMG/<?= $Result['BackupImagePath']; ?>"/>
                    <?php
                }
                ?>
            </div>
            <div class="col-lg-8">
                <div class="row">
                    <div class="col-md-9">
                        <h2 class="StockItemNameViewSize StockItemName"><?php print $Result['StockItemName']; ?></h2>
                    </div>
                    <div class="col-md-3" style="text-align: right">
                        <p class="StockItemPriceText"><b><?php print str_replace(".", ",", sprintf("€ %.2f", $Result['SellPrice'])); ?></b>
                        </p>
                        <h6> Inclusief BTW </h6>
                    </div>
                </div>
                <?php
                    if ($Result['IsChillerStock'] && isset($Temp)) {
                ?>
                    <div class="row">
                        <div class="col-12">
                            <div class="badge accent_background">Gekoeld: <?=$Temp['Temperature']?>°C</div>
                        </div>
                    </div>
                <?php
                    }
                ?>
<!--                    TODO: fix layout itemstock and addtocart form-->
                <div class="row">
                    <div class="col-md-4">
                        <?php if (($Result['QuantityOnHand'] >0 && $Result['QuantityOnHand'] < 100)){
                            $quantityText = "Nog maar " . ($Result ['QuantityOnHand']) . " beschikbaar ";
                            $quantityStyle = "background-color: #ffc107;";
                        } if (($Result['QuantityOnHand'] <=0 )){
                            $quantityText = "Tijdelijk uitverkocht";
                            $quantityStyle = "background-color: #dc3545;";
                        } if (($Result['QuantityOnHand'] >=100)){
                            $quantityText = "Ruime voorraad beschikbaar";
                            $quantityStyle = "background-color: #2F2F78;";
                        } ?>
                        <div class="badge" style="<?=$quantityStyle?>>"><?= $quantityText?></div>
                    </div>
                    <div class="col-md-8 col-sm-12 d-flex justify-content-center">
                        <form method="post" action="addCart.php">
                            <input type="hidden" name="StockItemID" value="<?= $Result['StockItemID'] ?>">
                            <div class="form-row align-items-center">
                                <div class="col-md-4 col-sm-4">
                                    <div class="input-group mb-2">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">Aantal:</div>
                                        </div>
                                        <input type="number" class="form-control" id="inlineFormInputGroup" value="1"
                                               name="quantity" min="1" max="<?= $Result['QuantityOnHand'] ?>">
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <button type="submit" class="btn btn-success mb-2 buttonBold" name="submitted">Toevoegen aan
                                        winkelwagen
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-4 StockItemDescriptionBox">
            <div class="col-md-6">
                <h3>Artikel beschrijving</h3>
                <p><?php print $Result['SearchDetails']; ?></p>
            </div>
            <div class="col-md-6">
                <h3>Artikel specificaties</h3>
                <?php
                $CustomFields = json_decode($Result['CustomFields'], true);
                if (is_array($CustomFields)) { ?>
                    <table>
                    <thead>
                    <th>Naam</th>
                    <th>Data</th>
                    </thead>
                    <?php
                    foreach ($CustomFields as $SpecName => $SpecText) { ?>
                        <tr>
                            <td>
                                <?php print $SpecName; ?>
                            </td>
                            <td>
                                <?php
                                if (is_array($SpecText)) {
                                    foreach ($SpecText as $SubText) {
                                        print $SubText . " ";
                                    }
                                } else {
                                    print $SpecText;
                                }
                                ?>
                            </td>
                        </tr>
                    <?php } ?>
                    </table><?php
                } else { ?>

                    <p><?php print $Result['CustomFields']; ?>.</p>
                    <?php
                }
                ?>
            </div>
        </div>
        <?php
        if (isset($Result['Video'])) {

            ?>
            <div class="row mt-2 embed-responsive" style="min-height: 500px">
                <?= $Result['Video'] ?>
            </div>
        <?php }
    } else {
        ?>
        <h2 id="ProductNotFound">Het opgevraagde product is niet gevonden.</h2>
        <?php
    }
    ?>
<script>
    $("#videoTrigger").click(e => {
        $("#videoDiv").slideToggle();
    })
</script>