<?php

require_once __DIR__ . '/../Model/UnloadingProfiles.php';

use Model\UnloadingProfiles;

$unload = new UnloadingProfiles();
$profiles = $unload->run();
