<?php

require_once __DIR__ . '/../Model/UnloadingProfiles.php';

$unload = new \Model\UnloadingProfiles();
$profiles = $unload->run();

foreach ($profiles as $id => $profile)
{
    if ($profile instanceof Model\Profile) {
        $profile->show();
        echo ' <a href="../View/editProfile.php?id=' . $id . '">Редактировать профайл</a> ';
        echo '<a href="../View/deleteProfile.php?id=' . $id . '">Удалить профайл</a> <br>';
    }
}