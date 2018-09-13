<?php

require_once __DIR__ . '/../index.php';
require_once __DIR__ . '/../../Model/Email.php';
require_once __DIR__ . '/../../Model/EmailRepository.php';

use Model\{ EmailRepository, Email };

if (isset($_POST['email_id']))
{

    $emailRepository = new EmailRepository();
    $emailRepository->changeMainEmail(
        $profiles[htmlentities($_GET['id'])],
        new Email(NULL, TRUE, htmlentities($_POST['email_id']))
    );

    header("Location: http://profil.es");
}