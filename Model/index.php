<?php

require_once __DIR__ . '/UnloadingProfiles.php';

$unload = new \Model\UnloadingProfiles();
$profiles = $unload->run();

foreach ($profiles as $profile)
{
    if ($profile instanceof Model\Profile) {
        $profile->show();
        $id = $profile->getId();
        var_dump($id);
        echo '<a href="../View/editProfile.php?id=' . $id . '">Редактировать профайл</a> <br>';
    }
}