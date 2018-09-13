<?php

require_once __DIR__ . '/../index.php';
require_once __DIR__ . '/../../Model/EmailRepository.php';

use Model\{ EmailRepository };

if (isset($_POST['email_id']))
{

    $emailRepository = new EmailRepository();
    $emailRepository->deleteById(htmlentities($_POST['email_id']));

    header("Location: http://profil.es");
}