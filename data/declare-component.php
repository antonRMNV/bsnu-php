<?php
    $f = fopen($path . "/" . $node, "r");
    $rowString = fgets($f);
    $rowArray = explode("/", $rowString);
    $component['file'] = $node;
    $component['name'] = $rowArray[0];
    $component['weight'] = $rowArray[1];
    $component['date'] = $rowArray[2];
    $component['necessarily'] = $rowArray[3];
    fclose($f);

    return $component;
?>