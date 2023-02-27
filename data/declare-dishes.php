<?php
$nameTmpl = '/^dish-\d\d\z/';
$path = __DIR__;
$conts = scandir($path);

$i = 0;
foreach ($conts as $node) {
    if(preg_match($nameTmpl, $node)) {
        $dishFolder = $node;
        require(__DIR__ . "/declare-dish.php");
        $data['dishes'][$i]['name'] = $data['dish']['name'];
        $data['dishes'][$i]['file'] = $dishFolder;
        $i++;
    }
}
?>