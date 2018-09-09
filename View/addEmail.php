<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Добавление почты</title>
</head>
<body>
    <form name="addInfo" method="post" action="../Controller/addEmail.php?id=<? echo $_GET['id'] ?>">
        <p> Добавить email </p>
        <input name="data" type="text" maxlength="30" size="30"> <br>
        <input name="submit" type="submit">
    </form>
</body>
</html>