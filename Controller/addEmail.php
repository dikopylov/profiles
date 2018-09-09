<?php

require_once __DIR__ . '/../Controller/unloadProfiles.php';
require_once __DIR__ . '/../Model/AddContact.php';

use Model\{ AddContact, Profile };

if (isset($_POST['data']))
{
    $clearId = htmlentities($_GET['id']);
    if ($profiles[$clearId] instanceof Profile)
    {
        $profiles[$clearId]->setId($clearId);

        $addContact = new AddContact($clearId, $_POST['data']);
        $addContact->run();
    }
    header("Location: http://profil.es/");
}