<?php

require_once __DIR__ . '/../Model/UnloadingProfiles.php';

$unload = new \Model\UnloadingProfiles();
$profiles = $unload->run();

