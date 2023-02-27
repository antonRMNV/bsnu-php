<?php
    include(__DIR__ . "/../authentication/check-auth.php");
    require_once '../model/autorun.php';
    $myModel = Model\Data::makeModel(Model\Data::FILE);
    $myModel->setCurrentUser($_SESSION['user']);

    $component = (new \Model\Component())->setId($_GET['file'])->setDishId($_GET['dish']);
    if(!$myModel->removeComponent($component)) {
        die($myModel->getError());
    } else {
        header('Location: ../index.php?dish=' . $_GET['dish']);
    }
?>