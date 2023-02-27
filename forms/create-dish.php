<?php
include(__DIR__ . "/../authentication/check-auth.php");
if (!CheckRight('dish', 'create')) {
    die('У вас недостатньо прав!');
}

$nameTemplate = '/^dish-\d\d\z/';
$path = __DIR__ . "/../data";
$const = scandir($path);
$i = 0;
foreach ($const as $node) {
    if (preg_match($nameTemplate, $node)) {
        $last_dish = $node;
    }
}
$dish_index = (string)(((int)substr($last_dish, -1, 2)) + 1);
if (strlen($dish_index) == 1) {
    $dish_index = "0" . $dish_index;
}
$newDishName = "dish-" . $dish_index;

mkdir(__DIR__ . "/../data/" . $newDishName);
$f = fopen(__DIR__ . "/../data/" . $newDishName . "/dish.txt", "w");
fwrite($f, "New; ; ");
fclose($f);
header('Location: ../index.php?dish=' . $newDishName);
?>