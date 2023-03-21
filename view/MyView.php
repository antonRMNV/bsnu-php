<?php

namespace View;

class MyView extends DishListView {

private function showDishes($dishes) {
?>
<form name="dish-form" method="get">
    <label for="dish">Страва</label>
    <select name="dish">
        <option value=""></option>
        <?php
        foreach ($dishes as $curdish) {
            echo "<option " . (($curdish->getId() == $_GET['dish']) ? "selected" : "") . " value='" . $curdish->getId() . "''>" . $curdish->getName() . "</option>";
        }
        ?>

    </select>
    <input type="submit" value="Перейти">
    <?php if ($this->checkRight('dish', 'create')): ?>
        <a href="?action=create-dish">Додати страву</a>
    <?php endif; ?>
</form>
<?php
}

private function showDish(\Model\Dish $dish) {
?>
<h2>Назва страви: <span class='dish-name'><?php echo $dish->getName(); ?></span></h2>
<h3>Тип страви: <span class='dish-type'><?php echo $dish->getType(); ?></span></h3>
<h3>Вага однієї порції: <span class='dish-weight'><?php echo $dish->getWeight(); ?></span></h3>
<?php if($this->checkRight('dish', 'edit')):?>
    <a href="?action=edit-dish-form&dish=<?php echo $_GET['dish']; ?>">Редагувати страву</a>
<?php endif; ?>
<?php if($this->checkRight('dish', 'delete')):?>
    <a href="?action=delete-dish&dish=<?php echo $_GET['dish']; ?>">Видалити страву</a>
<?php endif; ?>
<?php
}

private function showComponents($components) {
?>
<section>
    <?php if($_GET['dish']): ?>
        <?php if($this->checkRight('component', 'create')):?>
            <a href="?action=create-component-form&dish=<?php echo $_GET['dish']; ?>">Додати компонент</a>
        <?php endif; ?>
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
        <?php foreach ($components as $key => $component):?>
            <?php if(!$_POST['components_name_filter'] || stristr($component->getName(),
                    $_POST['components_name_filter'])): ?>
                <?php
                $row_class = 'row';
                ?>
                <tr class ='<?php echo $row_class; ?>'>
                    <td><?php echo ($key + 1); ?></td>
                    <td><?php echo $component->getName(); ?></td>
                    <td><?php echo $component->getWeight(); ?></td>
                    <td>
                        <?php if($this->checkRight('component', 'edit')):?>
                            <a href="?action=edit-component-form&dish=<?php echo $_GET['dish'];?>&file=<?php echo $component->getId(); ?>">Редагувати</a>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if($this->checkRight('component', 'delete')):?>
                            <a href="?action=delete-component&dish=<?php echo $_GET['dish'];?>&file=<?php echo $component->getId();?>">Видалити</a>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endif; ?>
        <?php endforeach; ?>

        </tbody>
    </table>
    <br>
    <?php endif;?>
</section>
<?php
}

public function showMainForm($dishes, \Model\Dish $dish, $components) {
?>
<!DOCTYPE html>
<html>
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
        <?php if ($this->checkRight('user','admin')): ?>
            <a href="?action=admin">Адміністрування</a>
        <?php endif; ?>
        <a href="?action=logout">Вийти</a>
    </div>
    <?php
    if($this->checkRight('dish', 'view')) {
        $this->showDishes($dishes);
        if($_GET['dish']) {
            $this->showDish($dish);
        }
    }
    ?>
</header>
<?php
if($this->checkRight('component', 'view')) {
    $this->showComponents($components);
}
?>
</body>
</html>
<?php
}

public function showDishEditForm(\Model\Dish $dish) {
?>
<!DOCTYPE html>
<html>
<head>
    <title>Редагування страви</title>
    <link rel="stylesheet" href="css/edit-dish-form-style.css">
</head>
<body>
<a href="index.php?dish=<?php echo $_GET['dish'];?>">На головну сторінку</a>
<form name='edit-dish' method="post" action="?action=edit-dish&dish=<?php echo $_GET['dish'];?>">
    <div><label for="name">Назва страви: </label><input type="text" name="name"
                                                        value="<?php echo $dish->getName(); ?>"></div>
    <div><label for="type">Тип страви: </label><input type="text" name="type"
                                                      value="<?php echo $dish->getType(); ?>"></div>
    <div><label for="weight">Вага однієї порції: </label><input type="text" name="weight"
                                                                value="<?php echo $dish->getWeight(); ?>"></div>
    <div><input type="submit" name="okay" value="Змінити"></div>
</form>
</body>
</html>
<?php
}

public function showComponentEditForm(\Model\Component $component) {
?>
<!DOCTYPE html>
<html>
<head>
    <title>Редагування компонента</title>
    <link rel="stylesheet" href="css/edit-component-form-style.css">
</head>
<body>
<a href="index.php?dish=<?php echo $_GET['dish'];?>">Повернутися на головну сторінку</a>
<form name='edit-component' method='post' action="?action=edit-component&file=<?php echo $_GET['file'];?>">
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
        <input type="date" name="component-change" value='<?php echo $component->getDate()?>'>
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
<?php
}

public function showComponentCreateForm() {
?>
<!DOCTYPE html>
<html>
<head>
    <title>Додавання компонента</title>
    <link rel="stylesheet" href="css/edit-component-form-style.css";
</head>
<body>
<a href="?dish=<?php echo $_GET['dish'];?>">Повернутися на головну сторінку</a>
<form name='create-component' method='post' action="?action=create-component&dish=<?php echo $_GET['dish'];?>">
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
<?php
}

public function showLoginForm() {
?>
<!DOCTYPE html>
<html>
<head>
    <title>Аутентифікація</title>
    <link rel="stylesheet" href="css/login-style.css">
</head>
<body>
<form method="post" action="?action=checkLogin">
    <p>
        <input type="text" name="username" placeholder="username">
    </p>
    <p>
        <input type="password" name="password" placeholder="password">
    </p>
    <p>
        <input type="submit" value="Авторизуватися">
    </p>
</form>
</body>
</html>
<?php
}

public function showAdminForm($users) {
?>
<!DOCTYPE html>
<html>
<head>
    <title>Адмін-панель</title>
</head>
<body>
<header>
    <a href="index.php">На головну сторінку</a>
    <h1>Адміністрування користувачів</h1>
    <link rel="stylesheet" href="css/main-style.css">
</header>
<section>
    <table>
        <thead>
        <tr>
            <th>Користувач</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($users as $user): ?>
            <?php if ($user->getUserName() != $_SESSION['user'] && $user->getUserName() != 'admin' && trim($user->getUserName()) != ''): ?>
                <tr>
                    <td>
                        <a href="?action=edit-user-form&username=<?php echo $user->getUserName(); ?>"><?php echo $user->getUserName(); ?></a>
                    </td>
                </tr>
            <?php endif; ?>
        <?php endforeach; ?>
        </tbody>
    </table>
</section>
</body>
</html>
<?php
}

public function showUserEditForm(\Model\User $user) {
?>
<!DOCTYPE html>
<html>
<head>
    <title>Редагування користувача</title>
    <link rel="stylesheet" href="admin.css">
</head>
<body>
<a href="?action=admin">До списку користувачів</a>
<form name='edit-user' method='post' action="?action=edit-user&user=<?php echo $_GET['user'];?>">
    <div name='tbl'>
        <div>
            <label for="user_name">Username: </label>
            <input readonly type="text" name="user_name" value= "<?php echo $user->getUserName(); ?>">
        </div>
        <div>
            <label for="pwd">Password: </label>
            <input type="text" name="user_pwd" value= "<?php echo $user->getPassword(); ?>">
        </div>
    </div>
    <div><p>Страва:</p>
        <input type="checkbox" <?php echo ("1" == $user->getRight(0))?"checked":""; ?> name="right0" value="1"><span>Перегляд</span>
        <input type="checkbox" <?php echo ("1" == $user->getRight(1))?"checked":""; ?> name="right1" value="1"><span>Створення</span>
        <input type="checkbox" <?php echo ("1" == $user->getRight(2))?"checked":""; ?> name="right2" value="1"><span>Редагування</span>
        <input type="checkbox" <?php echo ("1" == $user->getRight(3))?"checked":""; ?> name="right3" value="1"><span>Видалення</span>
    </div>
    <div><p>Компоненти:</p>
        <input type="checkbox" <?php echo ("1" == $user->getRight(4))?"checked":""; ?> name="right4" value="1"><span>Перегляд</span>
        <input type="checkbox" <?php echo ("1" == $user->getRight(5))?"checked":""; ?> name="right5" value="1"><span>Створення</span>
        <input type="checkbox" <?php echo ("1" == $user->getRight(6))?"checked":""; ?> name="right6" value="1"><span>Редагування</span>
        <input type="checkbox" <?php echo ("1" == $user->getRight(7))?"checked":""; ?> name="right7" value="1"><span>Видалення</span>
    </div>
    <div><p>Користувачі:</p>
        <input type="checkbox" <?php echo ("1" == $user->getRight(8))?"checked":""; ?> name="right8" value="1"><span>Адміністування</span>
    </div>
    <div><input type="submit" name="ok" value="Змінити"></div>
</form>
</body>
</html>
<?php
}
}