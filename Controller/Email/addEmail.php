<?php

require_once __DIR__ . '/../index.php';
require_once __DIR__ . '/../../Model/Email.php';
require_once __DIR__ . '/../../Model/EmailRepository.php';

use Model\{ EmailRepository, Email };

if (
    isset($_POST['email']) &&
    filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
{

    $emailRepository = new EmailRepository();
    $emailRepository->addToExistingProfile(
        $profiles[htmlentities($_GET['id'])],
        new Email(htmlentities($_POST['email']), htmlentities($_POST['is_main']))
    );

    header("Location: http://profil.es/");
}