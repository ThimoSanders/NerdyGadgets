<?php
include __DIR__ . "/header.php";

unset($_SESSION["login"]);

?>
    <div class="z">
        <label>U bent uitgelogd</label>
    </div>
    <div class="z2">
        <a href="login.php" class="HrefDecoration"><i style="color:#676EFF;"></i>Als u hierop klikt kunt u weer inloggen.</a>
        <script>
            window.setTimeout(() => {window.location.href = "http://localhost/NerdyGadgets/";}, 3000);
        </script>
    </div>
<?php
    include "footer.php";
?>