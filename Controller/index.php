<?php

require_once __DIR__ . '/../Model/ProfileRepository.php';
use \Model\ProfileRepository;
//add-mail.tpl.php
$profiles = (new ProfileRepository(
//    new \Model\EmailRepository(),
//    new PhoneRepo()
))->getAll();

