<?php
//messages with as key the $_GET['message'] value
$messages = [
    'register_success' => "Je account is succesvol aangemaakt.",
    'login_success' => "Je bent succesvol ingelogd."
];

if (isset($_GET['message'])) {
    switch ($_GET['message']) {
        //if message == register_success echo div
        case 'register_success':
            //div has class 'alert' and 'alert-success' for the styling and 'message' to be able to remove it with javascript
            echo "<div class='alert alert-success message'>{$messages['register_success']}</div>";
            break;
        case 'login_success':
            echo "<div class='alert alert-success message'>{$messages['login_success']}</div>";
            break;
    }
}
?>
<script>
    //foreach element with class 'message'
    $(".message").each(i => {
        //set timeout for 3 * 1000 milliseconds (3 seconds)
        window.setTimeout(() => {
            //removes specified element
            $(".message")[i].remove();
        }, 3 * 1000);
    })
</script>
