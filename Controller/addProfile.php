<?php

require_once __DIR__ . '/../Model/AddProfile.php';
require_once __DIR__ . '/../Model/Profile.php';

use Model\AddProfile;

if (isset($_POST['fullName']) && isset($_POST['email']) && isset($_POST['phone']))
{
    // вызываем метод в модели, который добавляет в базу данных новую карточку

    $addProfile = new AddProfile($_POST['fullName'], $_POST['email'], $_POST['phone']);
    $addProfile->run();

}