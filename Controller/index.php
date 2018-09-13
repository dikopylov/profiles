<?php

require_once __DIR__ . '/../Model/ProfileRepository.php';
require_once __DIR__ . '/../Model/EmailRepository.php';
require_once __DIR__ . '/../Model/PhoneRepository.php';
require_once __DIR__ . '/../Model/Database.php';

use Model\ { ProfileRepository, EmailRepository, PhoneRepository, Database };

Database::init();

$profiles = (
    new ProfileRepository
    (new EmailRepository(), new PhoneRepository()))
    ->getAll();
