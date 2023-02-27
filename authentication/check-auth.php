<?php
session_start();
if(!$_SESSION['user']) {
    header('Location: /lab1/authentication/login.php');
}
?>
