<?php
include __DIR__ . "/header.php";
?>

<!DOCTYPE html>
<html>
<head>

    <link rel="stylesheet" type="text/css" href="Public/CSS/style_betalingspagina.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">


    <style>
        body {
            font-family: Arial;
            font-size: 17px;
            padding: 8px;
        }

        * {
            box-sizing: border-box;
        }

        .row {
            display: -ms-flexbox; /* IE10 */
            display: flex;
            -ms-flex-wrap: wrap; /* IE10 */
            flex-wrap: wrap;
            margin: 0 -16px;
        }

        .col-25 {
            -ms-flex: 25%; /* IE10 */
            flex: 25%;
        }

        .col-50 {
            -ms-flex: 50%; /* IE10 */
            flex: 50%;
        }

        .col-75 {
            -ms-flex: 75%; /* IE10 */
            flex: 75%;
        }

        .col-25,
        .col-50,
        .col-75 {
            padding: 0 16px;
        }

        .container {
            background-color: #23232f;
            padding: 5px 20px 15px 20px;
            border-radius: 3px;
        }

        input[type=text] {
            width: 100%;
            margin-bottom: 20px;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }

        label {
            margin-bottom: 10px;
            display: block;
        }

        .icon-container {
            margin-bottom: 20px;
            padding: 7px 0;
            font-size: 24px;
        }

        .kleur {
            background-color: #4CAF50;
            color: white;
            padding: 12px;
            margin: 10px 0;
            border: none;
            width: 100%;
            border-radius: 3px;
            cursor: pointer;
            font-size: 17px;
        }

        .kleur:hover {
            background-color: #45a049;
        }

        a {
            color: #2196F3;
        }

        hr {
            border: 1px solid lightgrey;
        }

        span.price {
            float: right;
            color: grey;
        }

        @media (max-width: 800px) {
            .row {
                flex-direction: column-reverse;
            }
            .col-25 {
                margin-bottom: 20px;
            }
        }

    </style>


</head>
<body>

<div class="row">
    <div class="col-75">
        <div class="container">

            <div class="row">
                <div class="col-75">
                    <div class="container">
                        <form method="get" action="paid.php">
                            <!--De gebruiker moet zijn NAW gegevens kunnen invullen en als er iets niet ingevuld wordt krijgt hij/zij een melding-->

                            <div class="row">
                                <div class="col-50">
                                    <h3>Gegevens</h3>
                                    <label>Volledige Naam</label>
                                    <input type="text" naam="naam" required/>
                                    <label>E-mail</label>
                                    <input type="text" naam="e-mail" required>
                                    <label>Straat</label>
                                    <input type="text" naam="straat" required>
                                    <label>Stad</label>
                                    <input type="text" naam="stad" required>

                                    <!--Aan het eind van de gegevens komen er 2 velden naast elkaar-->

                                    <div class="row">
                                        <div class="col-50">
                                            <label>Huisnummer</label>
                                            <input type="text" naam="huisnummer" required>
                                        </div>
                                        <div class="col-50">
                                            <label>Land</label>
                                            <input type="text" naam="land" required>
                                        </div>
                                    </div>
                                </div>


                    <div class="col-50">
                        <h3>Betaalmethodes</h3>
                        <div class="icon-container">
                            <i class="fa fa-cc-visa" style="color:#f5f4f4;"></i>
                        </div>
                    </div>


                <input type="submit" value="Bestelling afronden" class="kleur">
            </form>
        </div>


</body>
</html>

