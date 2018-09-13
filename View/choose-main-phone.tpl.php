<?php
require_once __DIR__ . '/../Controller/index.php';

/**
 * @var \Model\Profile[] $profiles
 * @var \Model\Email $email
 * @var \Model\Phone $phone
 */
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title> Выбор основного телефона</title>
</head>
<body>
<form name="chooseMainMail" method="post" action="../Controller/Phone/chooseMainPhone.php?id=<?=$_GET['id']?>">
    <p> Выбор основного телефона </p>
    <?php foreach ($profiles[$_GET['id']]->getPhone() as $phone): if($phone->getIsMain() == TRUE) continue; ?>
        <p><input name="phone_id" type="radio"value='<?=$phone->getId()?>' checked> <?=$phone->getNumber()?></p>
    <?php endforeach; ?>
    <input name="submit" type="submit">
</form>
</body>
</html>