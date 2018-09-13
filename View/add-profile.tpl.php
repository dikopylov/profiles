<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Добавление профайла</title>
</head>
<body>
    <form name="main" method="post" action="../Controller/Profile/addProfile.php">
        <p>Фамилия</p>
        <input name="lastName" type="text" maxlength="30" size="30">
        <p>Имя</p>
        <input name="firstName" type="text" maxlength="30" size="30">
        <p>Отчество</p>
        <input name="patronymic" type="text" maxlength="30" size="30">
        <p>E-mail</p>
        <input name="email" type="text" maxlength="30" size="30">
        <p>Phone</p>
        <input name="phone" type="tel" pattern="[0-9]{1,11}" maxlength="30" size="30"> <br>
        <input name="submit" type="submit">

    </form>
</body>
</html>