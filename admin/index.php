<?php
require '../authentication/check-auth.php';
if (!CheckRight('user', 'admin')) {
    die('У вас недостатньо прав!');
}
require '../data/declare-users.php';
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
            <?php if ($user['name'] != $_SESSION['user'] && $user['name'] != 'admin' && trim($user['name']) != ''): ?>
                <tr>
                    <td>
                        <a href="edit-user.php?username=<?php echo $user['name']; ?>"><?php echo $user['name']; ?></a>
                    </td>
                </tr>
            <?php endif; ?>
        <?php endforeach; ?>
        </tbody>
    </table>
</section>
</body>
</html>
