<?php

require_once __DIR__ . '/../index.php';
require_once __DIR__ . '/../../Model/PhoneRepository.php';

use Model\{ PhoneRepository };

if (isset($_POST['phone_id']))
{
    $phoneRepository = new PhoneRepository();
    $phoneRepository->deleteById(htmlentities($_POST['phone_id']));

    header("Location: http://profil.es");
}