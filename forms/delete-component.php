<?php
include(__DIR__ . "/../authentication/check-auth.php");
if (!CheckRight('component', 'delete')) {
    die('У вас недостатньо прав!');
}
unlink(__DIR__ . "/../data/" . $_GET['dish'] . "/" . $_GET['file']);
header('Location: ../index.php?dish=' . $_GET['dish']);
?>