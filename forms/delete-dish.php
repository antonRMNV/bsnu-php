<?php
include(__DIR__ . "/../authentication/check-auth.php");
if (!CheckRight('dish', 'delete')) {
    die('У вас недостатньо прав!');
}
$dirName = "../data/" . $_GET['dish'];
$conts = scandir($dirName);
$i = 0;
foreach ($conts as $node) {
    @unlink($dirName . "/" . $node);
}
@rmdir($dirName);
header('Location: ../index.php');
?>