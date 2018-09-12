<?php

require_once __DIR__ . '/../Model/DeleteEmail.php';
require_once __DIR__ . '/../Controller/unloadProfiles.php';


use Model\{ DeleteEmail, Profile };

if (isset($_GET['id']) && isset($_POST['email_id']))
{
    $clearId = htmlentities($_GET['id']);

    $deleteProfile = new DeleteEmail($profiles[$clearId], $_POST['email_id']);
    $deleteProfile->run();

    header("Location: http://profil.es");
}