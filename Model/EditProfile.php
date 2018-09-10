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

        $id = $this->profile->getId();

        /** запрос нахождения ID, к которым принадлежат контактные данные пользователя*/
        $queriesContactsID = array(
            "SELECT email_id FROM profile_email WHERE profile_id = '$id' AND is_main = 1",
            "SELECT phone_id FROM profile_phone WHERE profile_id = '$id' AND is_main = 1"
        );

        // [0] - email, [1] - phone
        $result = array();

        $queriesUpdate = array("UPDATE profile SET
            last_name = '{$clearParameters['lastName']}', 
            first_Name = '{$clearParameters['firstName']}',
            patronymic = '{$clearParameters['patronymic']}' 
            WHERE id = '$id'",
            "UPDATE email SET email = '{$clearParameters['email']}' WHERE id = '{$result[0]}'",
            "UPDATE phone SET number = '{$clearParameters['phone']}' WHERE id = '{$result[1]}'");

        foreach ($queriesContactsID as $query)
        {
            if($result[] = $mysqli->query($query))
            {
                continue;
            }
            else die($mysqli->error);
        }

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

