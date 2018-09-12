<?php

require_once __DIR__ . '/../Model/DeletePhone.php';
require_once __DIR__ . '/../Controller/unloadProfiles.php';


use Model\{ DeletePhone, Profile };

if (isset($_GET['id']) && isset($_POST['phone_id']))
{
    $clearId = htmlentities($_GET['id']);

    $deleteProfile = new DeletePhone($profiles[$clearId], $_POST['phone_id']);
    $deleteProfile->run();

    header("Location: http://profil.es");
}