<?php
    require_once __DIR__ . '/Controller/index.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Система профайлов</title>
</head>
<body>
    <p><a href="View/add_profile.php">Добавить профайл</a></p>
        <table border="0">
                    <tr>
                        <th>Фамилия</th>
                        <th>Имя</th>
                        <th>Отчество</th>
                        <th>Основной email</th>
                        <th>Основной телефон</th>
                    </tr>
                    <?php foreach ($profiles as $id => $profile):?>
                    <tr>
                        <td><?=$profile->getLastName()?></td>
                        <td><?=$profile->getFirstName()?></td>
                        <td><?=$profile->getPatronymic()?></td>
<!--                        <td>--><?//=var_dump($profile->getEmail())?><!--</td>-->
                        <td><?=$profile->getMainEmail()['email']?></td>
                        <td><?=$profile->getMainPhone()['number']?></td>
                        <td><a href="/View/edit_profile.php?id=<?=$id?>">Редактировать профайл</a></td>
                        <td><a href="../Controller/deleteProfile.php?id=<?=$id?>">Удалить профайл</a></td>
                    </tr>
                    <?php endforeach; ?>
        </table>

</body>
</html>