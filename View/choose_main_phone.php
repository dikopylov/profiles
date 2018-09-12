<?php
require_once __DIR__ . '/../Controller/unloadProfiles.php';
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title> Выбор основного телефона</title>
</head>
<body>
<form name="chooseMainMail" method="post" action="../Controller/chooseMainPhone.php?id=<?=$_GET['id']?>">
    <p> Выбор основного телефона </p>
    <?php foreach ($profiles[$_GET['id']]->getPhone() as $phone): if($phone['phone_main'] == 1) continue; ?>
        <p><input name="phone_id" type="radio"value='<?=$phone['phone_id']?>' checked> <?=$phone['number']?></p>
    <?php endforeach; ?>
    <input name="submit" type="submit">
</form>
</body>
</html>