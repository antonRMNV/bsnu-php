<?php
    session_start();
    unset($_SESSION['user']);
    header('Location: /lab1/authentication/login.php');
?>