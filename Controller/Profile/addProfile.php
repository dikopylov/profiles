<?php

require_once __DIR__ . '/../../Model/ProfileRepository.php';
require_once __DIR__ . '/../../Model/PhoneRepository.php';
require_once __DIR__ . '/../../Model/EmailRepository.php';
require_once __DIR__ . '/../../Model/Profile.php';
require_once __DIR__ . '/../../Model/Email.php';
require_once __DIR__ . '/../../Model/Phone.php';

use Model\{ Profile, Email, Phone, ProfileRepository, EmailRepository, PhoneRepository };

if (
    isset($_POST['firstName']) && is_string($_POST['firstName']) &&
    isset($_POST['patronymic']) && is_string($_POST['patronymic']) &&
    isset($_POST['lastName']) && is_string($_POST['lastName']) &&
    isset($_POST['email']) && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) &&
    isset($_POST['phone'])
)
{
    //валидация входных данных
    $profile = new Profile(
        $_POST['firstName'],
        $_POST['patronymic'],
        $_POST['lastName'],
        new Email($_POST['email'], TRUE),
        new Phone($_POST['phone'], TRUE)
    );


    $profileRepository = new ProfileRepository(new EmailRepository(), new PhoneRepository());
    $profileRepository->add($profile);

    header("Location: http://profil.es");
}