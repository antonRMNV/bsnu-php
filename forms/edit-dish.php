<?php
    include(__DIR__ . "/../authentication/check-auth.php");
    if(!CheckRight('dish', 'edit')) {
        die('У вас недостатньо прав!');
    }

    if($_POST) {
        $f = fopen("../data/" . $_GET['dish'] . "/dish.txt", "w");
        $dishArray = array($_POST['name'], $_POST['type'], $_POST['weight']);
        $dishStr = implode("/", $dishArray);
        fwrite($f, $dishStr);
        fclose($f);
        header('Location: ../index.php?dish=' . $_GET['dish']);
    }
    $dishFolder = $_GET['dish'];
    require("../data/declare-dish.php");
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
            value="<?php echo $data['dish']['name']; ?>"></div>
        <div><label for="type">Тип страви: </label><input type="text" name="type"
            value="<?php echo $data['dish']['type']; ?>"></div>
        <div><label for="weight">Вага однієї порції: </label><input type="text" name="weight"
            value="<?php echo $data['dish']['weight']; ?>"></div>
        <div><input type="submit" name="okay" value="Змінити"></div>
    </form>
</body>
</html>