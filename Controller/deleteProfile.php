<?php

require_once __DIR__ . '/../Model/ProfileRepository.php';
require_once __DIR__ . '/../Model/Profile.php';

use Model\{ Profile, ProfileRepository };

if (isset($_GET['id']))
{
    $profileRepository = new ProfileRepository();
    $profileRepository->deleteById(htmlentities($_GET['id']));

    header("Location: http://profil.es");
}