<?php
    include(__DIR__ . "/../authentication/check-auth.php");
    require_once '../model/autorun.php';
    $myModel = Model\Data::makeModel(Model\Data::FILE);
    $myModel->setCurrentUser($_SESSION['user']);

    $component = (new \Model\Component())
        ->setDishId($_GET['dish'])
        ->setName($_POST['name'])
        ->setWeight($_POST['weight'])
        ->setDate(new DateTime($_POST['date']))
        ->setNecessarily($_POST['necessarily']);

    if(!$myModel->addComponent($component)) {
        die($myModel->getError());
    } else {
        header('Location: ../index.php?dish=' . $_GET['dish']);
    }
?>

<!DOCTYPE html>
<html>
<head>
    <title>Додавання компонента</title>
    <link rel="stylesheet" href="../css/edit-component-form-style.css";
</head>
<body>
<a href="../index.php">Повернутися на головну сторінку</a>
<form name='create-component' method='post'>
    <div>
        <label for="component_name">Назва компоненту: </label>
        <input type="text" name="component_name">
    </div>
    <div>
        <label for="component-weight">Вага на одну порцію: </label>
        <input type="text" name="component-weight">
    </div>
    <div>
        <label for="component-change">Дата зміни: </label>
        <input type="date" name="component-change">
    </div>
    <div>
        <input type="checkbox" name="necessarily-comp" value=1>Обов‘язковий компонент
    </div>
    <div>
        <input class="submit" type="submit" name="okay" value="Додати"
    </div>
</form>
</body>
</html>
