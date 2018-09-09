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
    <p>E-mail</p>
    <input name="email" type="text" maxlength="30" size="30" value=
        <? echo $profiles[$_GET['id']]->getEmail() ?>>
    <a href="addEmail.php?id=<? echo $_GET['id'] ?>">Добавить почту</a>
    <p>Phone</p>
    <input name="phone" type="text" maxlength="30" size="30" value=
        <? echo $profiles[$_GET['id']]->getPhone() ?>>
    <a href="addPhone.php?id=<? echo $_GET['id'] ?>">Добавить телефон</a> <br>
    <input name="submit" type="submit">

</form>
</body>
</html>

