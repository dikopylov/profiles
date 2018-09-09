<?php

require_once __DIR__ . '/../Model/AddProfile.php';
require_once __DIR__ . '/../Model/Profile.php';

use Model\AddProfile;

if (isset($_POST['firstName']) && isset($_POST['patronymic']) && isset($_POST['lastName']) &&
    isset($_POST['email']) && isset($_POST['phone']))
{
    // вызываем метод в модели, который добавляет в базу данных новую карточку

    $addProfile = new AddProfile($_POST['firstName'], $_POST['patronymic'], $_POST['lastName'],
        $_POST['email'], $_POST['phone']);
    $addProfile->run();

    header("Location: http://profi.es");
}