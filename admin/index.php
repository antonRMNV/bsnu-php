<?php
    require '../authentication/check-auth.php';
    require_once '../model/autorun.php';
    $myModel = Model\Data::makeModel(Model\Data::FILE);
    $myModel->setCurrentUser($_SESSION['user']);
    if(!$data['users'] = $myModel->readUsers()) {
        die($myModel->getError());
    }
?>

<!DOCTYPE html>
<html>
<head>
    <title>Адмін-панель</title>
</head>
<body>
<header>
    <a href="../index.php">На головну сторінку</a>
    <h1>Адміністрування користувачів</h1>
    <link rel="stylesheet" href="../css/main-style.css">
</header>
<section>
    <table>
        <thead>
        <tr>
            <th>Користувач</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($data['users'] as $user): ?>
            <?php if ($user->getUserName() != $_SESSION['user'] && $user->getUserName() != 'admin' && trim($user->getUserName()) != ''): ?>
                <tr>
                    <td>
                        <a href="edit-user.php?username=<?php echo $user->getUserName(); ?>"><?php echo $user->getUserName(); ?></a>
                    </td>
                </tr>
            <?php endif; ?>
        <?php endforeach; ?>
        </tbody>
    </table>
</section>
</body>
</html>
