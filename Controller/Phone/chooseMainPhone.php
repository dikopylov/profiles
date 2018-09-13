<?php

require_once __DIR__ . '/../index.php';
require_once __DIR__ . '/../../Model/Phone.php';
require_once __DIR__ . '/../../Model/PhoneRepository.php';

use Model\{ PhoneRepository, Phone };

if (isset($_POST['phone_id']))
{
    $emailRepository = new PhoneRepository();
    $emailRepository->changeMainPhone(
        $profiles[htmlentities($_GET['id'])],
        new Phone(NULL, TRUE, htmlentities($_POST['phone_id']))
    );

    header("Location: http://profil.es");
}