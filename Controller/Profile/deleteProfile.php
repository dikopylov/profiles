<?php

require_once __DIR__ . '/../../Model/ProfileRepository.php';
require_once __DIR__ . '/../../Model/PhoneRepository.php';
require_once __DIR__ . '/../../Model/EmailRepository.php';
require_once __DIR__ . '/../../Model/Profile.php';
require_once __DIR__ . '/../../Model/Email.php';
require_once __DIR__ . '/../../Model/Phone.php';

use Model\{ ProfileRepository, EmailRepository, PhoneRepository };

if (isset($_GET['id']))
{
    $profileRepository = new ProfileRepository(new EmailRepository(), new PhoneRepository());
    $profileRepository->deleteById(htmlentities($_GET['id']));

    header("Location: http://profil.es");
}