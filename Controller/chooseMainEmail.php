<?php

require_once __DIR__ . '/../Controller/unloadProfiles.php';
require_once __DIR__ . '/../Model/Email.php';

use Model\{ Email, Profile };

if (isset($_POST['email_id']))
{
    $clearId = htmlentities($_GET['id']);

    if ($profiles[$clearId] instanceof Profile)
    {
        $profiles[$clearId]->setId($clearId);

        $addEmail = new Email($clearId);
        $addEmail->changeMainEmail($_POST['email_id']);
    }
    header("Location: http://profil.es");
}