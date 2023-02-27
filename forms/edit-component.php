<?php
    include(__DIR__ . "/../authentication/check-auth.php");
    require_once '../model/autorun.php';
    $myModel = Model\Data::makeModel(Model\Data::FILE);
    $myModel->setCurrentUser($_SESSION['user']);

    if($_POST) {
        $component = (new \Model\Component())
            ->setDishId($_GET['dish'])
            ->setName($_POST['name'])
            ->setWeight($_POST['weight'])
            ->setDate(new DateTime($_POST['date']))
            ->setNecessarily($_POST['necessarily']);

        if(!$myModel->writeComponent($component)) {
            die($myModel->getError());
        } else {
            header('Location: ../index.php?dish=' . $_GET['dish']);
        }

        $component = $myModel->readComponent($_GET['dish'], $_GET['file']);
    }
?>

<!DOCTYPE html>
<html>
<head>
    <title>Редагування компонента</title>
    <link rel="stylesheet" href="../css/edit-component-form-style.css">
</head>
<body>
<a href="../index.php">Повернутися на головну сторінку</a>
<form name='edit-component' method='post'>
    <div>
        <label for="component_name">Назва компоненту: </label>
        <input type="text" name="component_name" value=<?php echo $component->getName(); ?>>
    </div>
    <div>
        <label for="component-weight">Вага на одну порцію: </label>
        <input type="text" name="component-weight" value=<?php echo $component->getWeight(); ?>>
    </div>
    <div>
        <label for="component-change">Дата зміни: </label>
        <input type="date" name="component-change" value='<?php echo $component->getDate()->format('Y-m-d'); ?>'>
    </div>
    <div>
        <input type="checkbox" <?php echo ("1" == $component->isPrivilege()) ? "checked" : ""; ?>
               name="necessarily-comp" value=1>Обов‘язковий компонент
    </div>
    <div>
        <input class="submit" type="submit" name="okay" value="Підтвердити редагування"
    </div>
</form>
</body>
</html>