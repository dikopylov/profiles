<?php

require_once __DIR__ . '/../Model/dataMysql.php';
require_once __DIR__ . '/../Model/UnloadingProfiles.php';

use Model\UnloadingProfiles;

$unload = new UnloadingProfiles();
$profiles = $unload->run();

if (isset($_POST['firstName']) && isset($_POST['patronymic']) && isset($_POST['lastName']) &&
    isset($_POST['email']) && isset($_POST['phone']))
{
    // вызываем метод в модели, который редактирует данные

    $editProfile = $profiles[$_GET['id']];
    $addProfile->run();
}


//if (array_key_exists($_GET['id'], $profiles))
//{
//    true;
//    /// Вызываем обработчик запроса на изменение в модели
//}
