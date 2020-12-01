<?php

include __DIR__ . "/header.php";
?>
    <!--Na het indrukken van de bestelling afronden knop wordt de gebruiker doorverwezen naar de paid pagina-->
<?php
$totalPrice = $_SESSION['totalPrice'];
$subTotaal = round($totalPrice / 1.21, 2);
$BTW = round($totalPrice - $subTotaal, 2);

?>

    <div class="row">
    <div class="col-75">
        <div class="container">
            <form method="post" action="paid.php">
                <!--De gebruiker moet zijn NAW gegevens kunnen invullen en als er iets niet ingevuld wordt krijgt hij/zij een melding-->
                <div class="row">
                    <div class="col-50">
                        <h3>Gegevens</h3>
                        <label>Volledige naam:</label>
                        <input placeholder="Volledige naam" type="text" name="vnaam" required value="<?php isset($_SESSION["login"]["FullName"]) ? print($_SESSION["login"]["FullName"]) : null ?>"/>
                        <label>E-mail:</label>
                        <input placeholder="E-mail" type="text" name="email" required value="<?php isset($_SESSION["login"]["LogonName"]) ? print($_SESSION["login"]["LogonName"]) : null ?>"/>
                        <label>Land:</label>
                        <input placeholder="Land" type="text" name="land" required value="<?php isset($_SESSION["login"]["Country"]) ? print($_SESSION["login"]["Country"]) : null ?>"/>
                        <label>Adres:</label>
                        <input placeholder="Adres" type="text" name="straat" required value="<?php isset($_SESSION["login"]["Address"]) ? print($_SESSION["login"]["Address"]) : null ?>"/>
                        <!--Aan het eind van de gegevens komen er 2 velden naast elkaar-->
                        <div class="row">
                            <div class="col-50">
                                <label>Postcode:</label>
                                <input placeholder="Postcode" type="text" name="postcode" required value="<?php isset($_SESSION["login"]["PostalCode"]) ? print($_SESSION["login"]["PostalCode"]) : null ?>"/>
                            </div>
                            <div class="col-50">
                                <label></label>
                            </div>
                        </div>
                    </div>

                    <div class="col-50">
                        <h3>Betalingsmethodes</h3>
                        <div class="icon-container">
                            <i class="fa fa-cc-visa" style="color:#FFFFFF;"></i>
                        </div>
                    </div>

                </div>
                    <input type="submit" name="knop" value="Bestelling afronden" class="kleur buttonBold" >
                <div>
                    <label>Subtotaal: &euro; <?= $subTotaal ?></label>
                    <label>BTW: &euro; <?= $BTW ?></label>
                </div>


                <div class="total">
                    <span class="i" id="total">Totaal: &euro; <?= $totalPrice ?></span>

                </div>

            </form>
        </div>
    </div>
<?php
include "footer.php";
?>