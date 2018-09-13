<?php

require_once __DIR__ . '/../index.php';
require_once __DIR__ . '/../../Model/Phone.php';
require_once __DIR__ . '/../../Model/PhoneRepository.php';

use Model\{ PhoneRepository, Phone };

if (isset($_POST['number']))
{
    $phoneRepository = new PhoneRepository();
    $phoneRepository->addToExistingProfile(
        $profiles[htmlentities($_GET['id'])],
        new Phone(htmlentities($_POST['number']), htmlentities($_POST['is_main']))
    );

    header("Location: http://profil.es/");
}