<?php
require_once __DIR__ . '/../Controller/unloadProfiles.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Редактирование профайла</title>
</head>
<body>
<form name="main" method="post" action="../Controller/editProfile.php?id=<? echo $_GET['id'] ?>">
    <p>Фамилия</p>
    <input name="firstName" type="text" maxlength="30" size="30" value=
        <? echo $profiles[$_GET['id']]->getFirstName()?>>
    <p>Имя</p>
    <input name="patronymic" type="text" maxlength="30" size="30" value=
        <? echo $profiles[$_GET['id']]->getPatronymic() ?>>
    <p>Отчество</p>
    <input name="lastName" type="text" maxlength="30" size="30" value=
        <? echo $profiles[$_GET['id']]->getLastName() ?>>
    <p>E-mail
        <a href="add_email.php?id=<? echo $_GET['id'] ?>">Добавить почту</a>
        <a href="choose_main_email.php?id=<? echo $_GET['id'] ?>">Выбор основной почты</a>
        <a href="delete_email.php?id=<? echo $_GET['id'] ?>">Удалить почту</a>
    </p>
    <input name="email" type="text" maxlength="30" size="30" value=
        <? echo $profiles[$_GET['id']]->getMainEmail()['email'] ?>>
    <p>Phone <a href="add_phone.php?id=<? echo $_GET['id'] ?>">Добавить телефон</a>
        <a href="choose_main_phone.php?id=<? echo $_GET['id'] ?>">Выбор основного телефона</a>
        <a href="delete_phone.php?id=<? echo $_GET['id'] ?>">Удалить телефон</a> </p>
    </p>
    <input name="phone" type="text" maxlength="30" size="30" value=
        <? echo $profiles[$_GET['id']]->getMainPhone()['number'] ?>>
     <br>
    <input name="submit" type="submit">

</form>
</body>
</html>

