<?php
require('authentication/check-auth.php');
require('data/declare-dishes.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Меню ресторану</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width = device-width, user-scalable=no, initial-scale=1.0,maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content=" ie=edge">

    <link rel="shortcut icon" href="https://png.pngtree.com/png-vector/20191023/ourlarge/pngtree-shawarma-icon-cartoon-style-png-image_1846637.jpg" type="image/png">
    <link rel="stylesheet" href="css/main-style.css">
    <link rel="stylesheet" href="css/weight-style.css">
</head>
<body>
<header>
    <div class="user-info">
        <span>Hello <?php echo $_SESSION['user']; ?></span>
        <a href="authentication/logout.php">Вийти</a>
    </div>
    <?php if(CheckRight('dish', 'view')):?>
        <form name = "dish-form" method="get">
            <label for="dish">Страва</label>
            <select name="dish">
                <option value=""></option>
                <?php
                foreach($data['dishes'] as $curdish) {
                    echo "<option " . (($_GET['dish']==$curdish['file'])?"selected":"") . " value=" . $curdish['file'] . ">" . $curdish['name'] . "</option>";
                }
                ?>

            </select>
            <input type="submit" value="Перейти">
            <?php if(CheckRight('dish', 'create')):?>
                <a href="forms/create-dish.php">Додати страву</a>
            <?php endif; ?>
        </form>

        <?php if($_GET['dish']): ?>
            <?php
            $dishFolder = $_GET['dish'];
            require('data/declare-data.php');
            ?>

            <h2>Назва страви: <span class='dish-name'><?php echo $data['dish']['name']; ?></span></h2>
            <h3>Тип страви: <span class='dish-type'><?php echo $data['dish']['type']; ?></span></h3>
            <h3>Вага однієї порції: <span class='dish-weight'><?php echo $data['dish']['weight']; ?></span></h3>
            <?php if(CheckRight('dish', 'edit')):?>
                <a href="forms/edit-dish.php?dish=<?php echo $_GET['dish']; ?>">Редагувати страву</a>
            <?php endif; ?>
            <?php if(CheckRight('dish', 'delete')):?>
                <a href="forms/delete-dish.php?dish=<?php echo $_GET['dish']; ?>">Видалити страву</a>
            <?php endif; ?>
            <hr>
            <h3>Компоненти страви:</h3>
        <?php endif; ?>
    <?php endif; ?>
</header>
<?php if(CheckRight('component', 'view')):?>
<section>
    <?php if($_GET['dish']): ?>
    <form name="components-filter" method="post">
        Фільтрувати за назвою <input type="text" name="components_name_filter"
                                     value='<?php echo $_POST['components_name_filter'];?>'>
        <input type="submit" value="Фільтрувати">
    </form>
<br>
    <table>
        <thead>
        <tr>
            <th>№</th>
            <th>Назва компоненту</th>
            <th>Вага на одну порцію, г</th>
            <th></th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($data['components'] as $key => $component):?>
            <?php if(!$_POST['components_name_filter'] || stristr($component['name'],
                    $_POST['components_name_filter'])): ?>
                <?php
                $row_class = 'row';

                ?>
                <tr class ='<?php echo $row_class; ?>'>
                    <td><?php echo ($key + 1); ?></td>
                    <td><?php echo $component['name']; ?></td>
                    <td><?php echo $component['weight']; ?></td>
                    <td>
                        <?php if(CheckRight('component', 'edit')):?>
                            <a href="forms/edit-component.php?dish=<?php echo $_GET['dish'];?>&file=<?php echo $component['file']; ?>">Редагувати</a>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if(CheckRight('component', 'delete')):?>
                            <a href="forms/delete-component.php?dish=<?php echo $_GET['dish'];?>&file=<?php echo $component['file'];?>">Видалити</a>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endif; ?>
        <?php endforeach; ?>
        <?php endif;?>
        </tbody>
    </table>
    <br>
    <?php if(CheckRight('component', 'create')):?>
        <a href="forms/create-component.php?dish=<?php echo $_GET['dish']; ?>">Додати компонент</a>
    <?php endif; ?>
    <?php endif; ?>
</section>
</body>
</html>
