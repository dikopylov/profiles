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
    <title>Удаление неосновного телефон</title>
</head>
<body>
<form name="deleteMail" method="post" action="../Controller/Phone/deletePhone.php?>">
    <p> Удаление неосновного телефон </p>
    <?php foreach ($profiles[$_GET['id']]->getPhone() as $phone):
        if($phone->getIsMain() == TRUE) continue; ?>
        <p><input name="phone_id" type="radio"value='<?= $phone->getId()?>' checked>
            <?=$phone->getNumber()?></p>
    <?php endforeach; ?>
    <input name="submit" type="submit">
</form>
</body>
</html>