<?php

require_once __DIR__ . '/../Controller/unloadProfiles.php';
require_once __DIR__ . '/../Model/AddEmail.php';

use Model\{ AddEmail, Profile };

if (isset($_POST['data']))
{
    $clearId = htmlentities($_GET['id']);

    if ($profiles[$clearId] instanceof Profile)
    {
        $profiles[$clearId]->setId($clearId);

        $addEmail = new AddEmail($clearId, $_POST['data'], $_POST['is_main']);
        $addEmail->run();
    }
    header("Location: http://profil.es/");
}