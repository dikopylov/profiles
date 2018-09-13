<?php

require_once __DIR__ . '/../Model/ProfileRepository.php';
require_once __DIR__ . '/../Model/Profile.php';

use Model\{ Profile, ProfileRepository };

if (isset($_POST['firstName']) && isset($_POST['patronymic']) && isset($_POST['lastName']) &&
    isset($_POST['email']) && isset($_POST['phone']))
{
    $profileRepository = new ProfileRepository();
    $profileRepository->edit($_GET['id'], $_POST['firstName'], $_POST['patronymic'], $_POST['lastName'],
        $_POST['email'], $_POST['phone']);

    header("Location: http://profil.es");
}
