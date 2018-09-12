<?php

namespace Model;

require_once __DIR__ . '/dataMysql.php';
require_once __DIR__ . '/Profile.php';

class EditProfile extends Profile
{
    // Профайл с новыми данными
    private $profile;

    public function __construct(Profile $profile, $firstName, $patronymic, $lastName, $email, $phone, $id = NULL)
    {
        parent::__construct($firstName, $patronymic, $lastName, $email, $phone, $id);
        $this->profile = $profile;
    }

    public function run()
    {
        $mysqli = new \mysqli(host, user,password,database);

        $clearParameters = array(
            "last_name" => parent::getLastName(),
            "first_name" => parent::getFirstName(),
            "patronymic" => parent::getPatronymic(),

        );

        $clearParametersContacts = array(
            "email" => parent::getEmail(),
            "phone" => parent::getPhone()
        );

        foreach ($clearParameters as $key => $clearParameter)
        {
            $clearParameters[$key] = $mysqli->real_escape_string($clearParameter);
        }

        foreach ($clearParametersContacts as $keys => $clearParameter)
        {
            foreach ($clearParameter as $key => $clearParam)
            {
                $clearParametersContacts[$key] = $mysqli->real_escape_string($clearParam);
            }

        }

        $id = $this->profile->getId();

        /** запрос нахождения ID, к которым принадлежат контактные данные пользователя*/
        $queriesContactsID = array(
            "SELECT email_id FROM profile_email WHERE profile_id = $id AND is_main = 1",
            "SELECT phone_id FROM profile_phone WHERE profile_id = $id AND is_main = 1"
        );

        // NEW
            $Contacts = array(
                "email" => "email",
                "phone" => "phone"
            );

            $Name = array(
                "last_name" => "last_name",
                "first_name" => "first_name",
                "patronymic" => "patronymic"
            );

            $queryContact = array();

            $resultContactID = array(
            "email" => NULL,
            "phone" => NULL
            );

            foreach ($Contacts as $key => $contact)
            {
                $queryContact[$key] = "SELECT " . $contact  ."_id FROM profile_" . $contact . " WHERE profile_id = $id AND is_main = 1";
                if ($resultQuery = $mysqli->query($queryContact[$key]))
                {
                    $resultContactID[$key] = $resultQuery->fetch_assoc();
                }
                else
                    die($mysqli->error);
            }

        $queriesUpdateName = array("UPDATE profile SET
            last_name = '{$clearParameters['lastName']}', 
            first_Name = '{$clearParameters['firstName']}',
            patronymic = '{$clearParameters['patronymic']}' 
            WHERE id = '$id'" //,
//            "UPDATE email SET email = '{$clearParametersContacts['email'][0]}' WHERE id = '{$result[0]['email_id']}'",
//            "UPDATE phone SET number = '{$clearParametersContacts['phone'][0]}' WHERE id = '{$result[1]['phone_id']}'"
        );

        // NEW

        // [0] - email, [1] - phone
        $result = array();

        foreach ($queriesContactsID as $query)
        {
            if($res = $mysqli->query($query))
            {
                $result[] = $res->fetch_assoc();
            }
            else die($mysqli->error);
        }


        $queriesUpdate = array("UPDATE profile SET
            last_name = '{$clearParameters['lastName']}', 
            first_Name = '{$clearParameters['firstName']}',
            patronymic = '{$clearParameters['patronymic']}' 
            WHERE id = '$id'",
            "UPDATE email SET email = '{$clearParametersContacts['email'][0]}' WHERE id = '{$result[0]['email_id']}'",
            "UPDATE phone SET number = '{$clearParametersContacts['phone'][0]}' WHERE id = '{$result[1]['phone_id']}'");

        foreach ($queriesUpdate as $query)
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

