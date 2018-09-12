<?php


require_once __DIR__ . '/../Model/DeleteProfile.php';
require_once __DIR__ . '/../Controller/unloadProfiles.php';

use Model\{ DeleteProfile, Profile };

if (isset($_GET['id']))
{
    $clearId = htmlentities($_GET['id']);

    $deleteProfile = new DeleteProfile($profiles[$clearId]);
    $deleteProfile->run();

    header("Location: http://profil.es");
}