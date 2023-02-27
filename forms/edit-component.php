<?php
include(__DIR__ . "/../authentication/check-auth.php");
if (!CheckRight('component', 'edit')) {
    die('У вас недостатньо прав!');
}
if ($_POST) {
    $f = fopen('../data/' . $_GET['dish'] . "/" . $_GET['file'], "w");
    $comp_necessarily = 0;
    if ($_POST['necessarily-comp'] == 1) {
        $comp_necessarily = 1;
    }
    $componentsArr = array($_POST['component_name'], $_POST['component-weight'], $_POST['component-change'], $comp_necessarily);
    $componentsStr = implode("/", $componentsArr);
    fwrite($f, $componentsStr);
    fclose($f);
    header('Location: ../index.php?dish=' . $_GET['dish']);
}

$path = __DIR__ . "/../data/" . $_GET['dish'];
$node = $_GET['file'];
$component = require __DIR__ . '/../data/declare-component.php';
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
        <input type="text" name="component_name" value=<?php echo $component['name'] ?>>
    </div>
    <div>
        <label for="component-weight">Вага на одну порцію: </label>
        <input type="text" name="component-weight" value=<?php echo $component['weight'] ?>>
    </div>
    <div>
        <label for="component-change">Дата зміни: </label>
        <input type="date" name="component-change" value='<?php echo $component['date']; ?>'>
    </div>
    <div>
        <input type="checkbox" <?php echo ("1" == $component['necessarily']) ? "checked" : ""; ?>
               name="necessarily-comp" value=1>Обов‘язковий компонент
    </div>
    <div>
        <input class="submit" type="submit" name="okay" value="Підтвердити редагування"
    </div>
</form>
</body>
</html>