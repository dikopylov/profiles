<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Добавление телефона</title>
</head>
<body>
<form name="addInfo" method="post" action="../Controller/Phone/addPhone.php?id=<?=$_GET['id']?>">
    <p> Добавить телефон </p>
    <input name="number" type="tel" pattern="[0-9]{1,11}" maxlength="30" size="30"> <br>
    <p><input type="checkbox" name="is_main" value="1"> Сделать этот телефон основным</p>
    <input name="submit" type="submit">
</form>
</body>
</html>