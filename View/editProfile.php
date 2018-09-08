<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Редактирование профайла</title>
</head>
<body>
<form name="main" method="post" action="../Controller/editProfile.php">
    <p>ФИО</p>
    <input name="fullName" type="text" maxlength="30" size="30" value=<?  >
    <p>E-mail</p>
    <input name="email" type="text" maxlength="30" size="30">
    <p>Phone</p>
    <input name="phone" type="text" maxlength="30" size="30"> <br>
    <input name="submit" type="submit">

</form>
</body>
</html>