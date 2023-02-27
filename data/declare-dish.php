<?php
    $f = fopen(__DIR__ . "/" . $dishFolder . "/dish.txt", "r");
    $dishStr = fgets($f);
    $dishArr = explode("/", $dishStr);
    fclose($f);

    $data['dish'] = array (
        'name' => $dishArr[0],
        'type' => $dishArr[1],
        'weight' => $dishArr[2]
    );
?>