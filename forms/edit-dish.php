<?php
    include(__DIR__ . "/../authentication/check-auth.php");
    require_once '../model/autorun.php';
    $myModel = Model\Data::makeModel(Model\Data::FILE);
    $myModel->setCurrentUser($_SESSION['user']);

    if($_POST) {
        if(!$myModel->writeDish((new \Model\Dish())
            ->setId($_GET['dish'])
            ->setName($_POST['name'])
            ->setWeight(($_POST['weight']))
            ->setType($_POST['type'])
         )) {
            die($myModel->getError());
        } else {
            header('Location: ../index.php?dish=' . $_GET['dish']);
        }
    }
    if(!$data['dish'] = $myModel->readDish($_GET['dish'])) {
        die($myModel->getError());
    }
?>

<!DOCTYPE html>
<html>
<head>
    <title>Редагування страви</title>
    <link rel="stylesheet" href="../css/edit-dish-form-style.css">
</head>
<body>
    <a href="/lab1/index.php">На головну сторінку</a>
    <form name='edit-dish' method="post">
        <div><label for="name">Назва страви: </label><input type="text" name="name"
            value="<?php echo $data['dish']->getName(); ?>"></div>
        <div><label for="type">Тип страви: </label><input type="text" name="type"
            value="<?php echo $data['dish']->getType(); ?>"></div>
        <div><label for="weight">Вага однієї порції: </label><input type="text" name="weight"
            value="<?php echo $data['dish']->getWeight(); ?>"></div>
        <div><input type="submit" name="okay" value="Змінити"></div>
    </form>
</body>
</html>