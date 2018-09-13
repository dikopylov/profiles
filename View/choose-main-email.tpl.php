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
    <title>Выбор основной почты</title>
</head>
<body>
<form name="chooseMainMail" method="post" action="../Controller/Email/chooseMainEmail.php?id=<?=$_GET['id']?>">
    <p> Выбор основной почты </p>
    <?php foreach ($profiles[$_GET['id']]->getEmail() as $email): if($email->getIsMain() == TRUE) continue; ?>
    <p><input name="email_id" type="radio"value='<?=$email->getId()?>' checked> <?=$email->getEmail()?></p>
    <?php endforeach; ?>
    <input name="submit" type="submit">
</form>
</body>
</html>