<?php
include __DIR__ . "/header.php";

unset($_SESSION["login"]);

?>
    <div class="z">
        <label>U bent uitgelogd</label>
    </div>
    <div class="z2">
        <a href="login.php" class="HrefDecoration"><i style="color:#676EFF;"></i>Als u hierop klikt kunt u weer inloggen.</a>
    </div>
<?php
    include "footer.php";
?>