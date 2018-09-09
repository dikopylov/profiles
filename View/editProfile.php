<?php

require_once __DIR__ . '/../Model/UnloadingProfiles.php';

$unload = new \Model\UnloadingProfiles();
$profiles = $unload->run();

if (array_key_exists($_GET['id'], $profiles))
{
    $profile = $profiles[$_GET['id']];
    /// Вызываем обработчик запроса на изменение в модели
}
else
{
    header('Location: http://profil.es');
}
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
        <? echo $profile instanceof Model\Profile ? $profile->getFirstName() : NULL ?>>
    <p>Имя</p>
    <input name="patronymic" type="text" maxlength="30" size="30" value=
        <? echo $profile instanceof Model\Profile ? $profile->getPatronymic() : NULL ?>>
    <p>Отчество</p>
    <input name="lastName" type="text" maxlength="30" size="30" value=
        <? echo $profile instanceof Model\Profile ? $profile->getLastName() : NULL ?>>
    <p>E-mail</p>
    <input name="email" type="text" maxlength="30" size="30" value=
        <? echo $profile instanceof Model\Profile ? $profile->getPhone() : NULL ?>>
    <p>Phone</p>
    <input name="phone" type="text" maxlength="30" size="30" value=
        <? echo $profile instanceof Model\Profile ? $profile->getEmail() : NULL ?>> <br>
    <input name="submit" type="submit">

</form>
</body>
</html>

