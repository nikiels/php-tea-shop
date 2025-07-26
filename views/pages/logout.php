<?php
unset($_SESSION['logged_user']);
unset($_SESSION['cart']);
unset($_SESSION['logged_admin']);

header('Location: index.php');
?>
