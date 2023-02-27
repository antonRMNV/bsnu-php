<?php
    $nameTmpl = '/^component-\d\d.txt\z/';
    $path = __DIR__ . "/" . $dishFolder;
    $conts = scandir($path);

    $i = 0;
    foreach ($conts as $node) {
        if(preg_match($nameTmpl, $node)) {
            $data['components'][$i] = require __DIR__ . '/declare-component.php';
            $i++;
        }
    }
?>