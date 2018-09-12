<?php

require_once __DIR__ . '/../Controller/unloadProfiles.php';
require_once __DIR__ . '/../Model/Phone.php';

use Model\{ Phone, Profile };

if (isset($_POST['data']))
{
    $clearId = htmlentities($_GET['id']);

    if ($profiles[$clearId] instanceof Profile)
    {
        $profiles[$clearId]->setId($clearId);

        $addEmail = new Phone($clearId);
        $addEmail->add($_POST['data'], $_POST['is_main']);
    }
    header("Location: http://profil.es/");
}