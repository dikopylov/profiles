<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Добавление почты</title>
</head>
<body>
    <form name="addInfo" method="post" action="../Controller/Email/addEmail.php?id=<?=$_GET['id']?>">
        <p> Добавить email </p>
        <input type="text" name="email" maxlength="30" size="30"> <br>
        <p><input type="checkbox" name="is_main" value="1"> Сделать этот Email основным</p>
        <input name="submit" type="submit">
    </form>
</body>
</html>