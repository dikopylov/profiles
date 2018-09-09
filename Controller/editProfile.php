<?php

require_once __DIR__ . '/../Model/EditProfile.php';
require_once __DIR__ . '/../Model/Profile.php';
require_once __DIR__ . '/../Controller/unloadProfiles.php';

use Model\{ EditProfile, Profile };


if (isset($_POST['firstName']) && isset($_POST['patronymic']) && isset($_POST['lastName']) &&
    isset($_POST['email']) && isset($_POST['phone']))
{
    $clearId = htmlentities($_GET['id']);

    if ($profiles[$clearId] instanceof Profile)
    {
        $profiles[$clearId]->setId($clearId);

        $editProfile = new EditProfile($profiles[$clearId], $_POST['firstName'], $_POST['patronymic'],
            $_POST['lastName'], $_POST['email'], $_POST['phone']);
        $editProfile->run();
    }
    header("Location: http://profil.es");
}
