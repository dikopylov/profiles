<?php
    require_once __DIR__ . '/Controller/index.php';
    /**
     * @var \Model\Profile[] $profiles
     *
     */
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Система профайлов</title>
</head>
<body>
    <p><a href="View/add_profile.php">Добавить профайл</a></p>

    <style type="text/css">
        TABLE {
            /*width: 1500px; !* Ширина таблицы *!*/
            border: 1px solid black; /* Рамка вокруг таблицы */
            border-bottom: none; /* Убираем линию снизу */
        }
        TD, TH {
            padding: 3px; /* Поля вокруг содержимого ячеек */
            text-align: center;
        }
        TH {
            text-align: center; /* Выравнивание по левому краю */
        }
        TD {
            border-bottom: 1px solid black; /* Линия снизу */
        }
    </style>

        <table cellspacing="0">
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
                        <td>
                            <?php
                                foreach ($profile->getEmail() as $key => $email)
                                {
                                if ($email["email_main"] == 1) {
                                    echo '<strong style="color: green">' . $email["email"] . '</strong>' . '<br>';
                                } else
                                    echo $email["email"] . '<br>';
                                }
                            ?>
                        </td>
                        <td>
                            <?php
                            foreach ($profile->getPhone() as $key => $phone)
                            {
                                if ($phone["phone_main"] == 1) {
                                    echo '<strong style="color: green">' . $phone["number"] . '</strong>' . '<br>';
                                } else
                                    echo $phone["number"] . '<br>';
                            }
                            ?>
                        </td>
                        <td><a href="/View/edit_profile.php?id=<?=$id?>">Редактировать профайл</a></td>
                        <td><a href="Controller/deleteProfile.php?id=<?=$id?>">Удалить профайл</a></td>
                    </tr>
                    <?php endforeach; ?>
        </table>

</body>
</html>