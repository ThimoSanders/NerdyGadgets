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
                        <label>Volledige naam</label>
                        <input type="text" name="vnaam" required value="<?php isset($_SESSION["login"]["FullName"]) ? print($_SESSION["login"]["FullName"]) : "" ?>"/>
                        <label>E-mail</label>
                        <input type="text" name="email" required value="<?php isset($_SESSION["login"]["LogonName"]) ? print($_SESSION["login"]["LogonName"]) : "" ?>"/>
                        <label>Land</label>
                        <input type="text" name="land" required value="<?php isset($_SESSION["login"]["Country"]) ? print($_SESSION["login"]["Country"]) : "" ?>"/>
                        <label>Straat</label>
                        <input type="text" name="straat" required value="<?php isset($_SESSION["login"]["Address"]) ? print($_SESSION["login"]["Address"]) : "" ?>"/>
                        <!--Aan het eind van de gegevens komen er 2 velden naast elkaar-->
                        <div class="row">
                            <div class="col-50">
                                <label>Huisnummer</label>
                                <input type="text" name="huisnummer" required>
                            </div>
                            <div class="col-50">
                                <label>Postcode</label>
                                <input type="text" name="postcode" required value="<?php isset($_SESSION["login"]["PostalCode"]) ? print($_SESSION["login"]["PostalCode"]) : "" ?>"/>
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