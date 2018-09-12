<?php
require_once __DIR__ . '/../Controller/unloadProfiles.php';
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Выбор основной почты</title>
</head>
<body>
<form name="chooseMainMail" method="post" action="../Controller/chooseMainEmail.php?id=<?=$_GET['id']?>">
    <p> Выбор основной почты </p>
    <?php foreach ($profiles[$_GET['id']]->getEmail() as $mail): if($mail['email_main'] == 1) continue; ?>
    <p><input name="email_id" type="radio"value='<?=$mail['email_id']?>' checked> <?=$mail['email']?></p>
    <?php endforeach; ?>
    <input name="submit" type="submit">
</form>
</body>
</html>