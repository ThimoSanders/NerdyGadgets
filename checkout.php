<?php
include __DIR__ . "/header.php";
?>
<!--Na het indrukken van de bestelling afronden knop wordt de gebruiker doorverwezen naar de paid pagina-->
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="Public/CSS/style_betalingspagina.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">

</head>
<body>


<?php
$totalPrice= $_SESSION['totalPrice'];
$subTotaal= round($totalPrice/ 1.21, 2);
$BTW= round($totalPrice - $subTotaal, 2);

?>

<div class="row">
    <div class="col-75">
        <div class="container">
            <form method="get" action="paid.php">
<!--De gebruiker moet zijn NAW gegevens kunnen invullen en als er iets niet ingevuld wordt krijgt hij/zij een melding-->
                <div class="row">
                    <div class="col-50">
                        <h3>Gegevens</h3>
                        <label>Volledige naam</label>
                        <input type="text" naam="vnaam" required/>
                        <label>E-mail</label>
                        <input type="text" naam="email" required>
                        <label>Land</label>
                        <input type="text" naam="land" required>
                        <label>Straat</label>
                        <input type="text" naam="straat" required>
<!--Aan het eind van de gegevens komen er 2 velden naast elkaar-->
                        <div class="row">
                            <div class="col-50">
                                <label>Huisnummer</label>
                                <input type="text" naam="huisnummer" required>
                            </div>
                            <div class="col-50">
                                <label>Postcode</label>
                                <input type="text" naam="postcode" required>
                            </div>
                        </div>
                    </div>

                    <div class="col-50">
                        <h3>Betalingsmethodes</h3>
                        <div class="icon-container">
                            <i class="fa fa-cc-visa" style="color:#f5f4f4;"></i>
                        </div>
                    </div>

                </div>
                <input type="submit" value="Bestelling afronden" class="kleur" >

                <div>
                    <label>Subtotaal: &euro; <?= $subTotaal?></label>
                    <label>BTW: &euro; <?= $BTW?></label>
                </div>




                <div class="total">
                    <span class="i" id="total">Totaal: &euro; <?= $totalPrice?></span>

                </div>

            </form>
        </div>
    </div>


</body>
</html>