<?php

namespace Model;

require_once __DIR__ . '/dataMysql.php';
require_once __DIR__ . '/IAction.php';
require_once __DIR__ . '/Action.php';
require_once __DIR__ . '/Profile.php';

class AddProfile extends Profile
{
    public function __construct($firstName, $patronymic, $lastName, $email, $phone)
    {
        parent::__construct($firstName, $patronymic, $lastName, $email, $phone);
    }

    function run()
    {
        $mysqli = new \mysqli(host, user,password,database);

        $clearParameters = array(
            "lastName" => parent::getLastName(),
            "firstName" => parent::getFirstName(),
            "patronymic" => parent::getPatronymic(),
            "email" => parent::getEmail(),
            "phone" => parent::getPhone()
        );

        foreach ($clearParameters as $key => $clearParameter)
        {
            $clearParameters[$key] = $mysqli->real_escape_string($clearParameter);
        }

        $queriesProfile = array("
            INSERT INTO profile VALUES(NULL, '{$clearParameters['lastName']}', '{$clearParameters['firstName']}',
           '{$clearParameters['patronymic']}')",
            "INSERT INTO email VALUES(NULL, '{$clearParameters['email']}')",
            "INSERT INTO phone VALUES(NULL,  '{$clearParameters['phone']}')");

        $id = array();

        foreach ($queriesProfile as $query)
        {
            if($mysqli->query($query))
            {
                $id[] = $mysqli->insert_id;
            }
            else die($mysqli->error);
        }

        $queriesProfileContacts = array(
            "INSERT INTO profile_email VALUES(NULL, '{$id[0]}', '{$id[1]}', TRUE)",
            "INSERT INTO profile_phone VALUES(NULL, '{$id[0]}', '{$id[2]}', TRUE)"
        );

        foreach ($queriesProfileContacts as $query)
        {
            if($mysqli->query($query))
            {
                continue;
            }
            else die($mysqli->error);
        }

        $mysqli->close();

    }

}