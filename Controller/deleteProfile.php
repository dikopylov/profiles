<?php


require_once __DIR__ . '/../Model/DeleteProfile.php';

use Model\DeleteProfile;

if (isset($_GET['id']))
{
    $clearId = htmlentities($_GET['id']);

    $deleteProfile = new DeleteProfile($clearId);
    $deleteProfile->run();

    header("Location: http://profil.es");
}