<?php
include(__DIR__ . "/../authentication/check-auth.php");
if(!CheckRight('component', 'create')) {
    die('У вас недостатньо прав!');
}
if ($_POST) {
    $nameTemplate = '/^component-\d\d.txt\z/';
    $path = __DIR__ . "/../data/" . $_GET['dish'];
    $const = scandir($path);
    $i = 0;
    foreach ($const as $node) {
        if (preg_match($nameTemplate, $node)) {
            $last_file = $node;
        }
    }
    $file_index = (string)(((int)substr($last_file, -6, 2)) + 1);
    if (strlen($file_index) == 1) {
        $file_index = "0" . $file_index;
    }
    $newFileName = "component-" . $file_index . ".txt";

    $f = fopen("../data/" . $_GET['dish'] . "/" . $newFileName, "w");
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
