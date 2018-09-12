<?php

namespace Model;

require_once __DIR__ . '/IAction.php';
require_once __DIR__ . '/Profile.php';

class UnloadingProfiles implements IAction
{
    // Выгрузка профайлов из БД в объекты
    public function run()
    {
        $mysqli = new \mysqli(host, user, password, database);

        $query = "SELECT profile.id, profile.first_name, profile.patronymic, profile.last_name,
            profile_email.email_id, profile_email.is_main AS email_main, 
            profile_phone.phone_id, profile_phone.is_main AS phone_main, 
            email.email, phone.number
            FROM ((((profile
            JOIN profile_email ON profile.id = profile_email.profile_id)
            JOIN profile_phone ON profile.id = profile_phone.profile_id)
            JOIN email on profile_email.email_id = email.id)
            JOIN phone on profile_phone.phone_id = phone.id)";

        $profiles = array();

        $uniqueData = array(
            'profile_id' => array(),
            'email_id' => array(),
            'phone_id' => array()
        );

        $result = array(
            'Join' => NULL,
            'Email' => NULL,
            'Phone' => NULL
        );

        if ($result['Join'] = $mysqli->query($query)) {

            while ($row = $result['Join']->fetch_assoc()) {

                $email = array(
                    'email_id' => $row['email_id'],
                    'email' => $row['email'],
                    'email_main' => $row['email_main']
                );

                $phone = array(
                    'phone_id' => $row['phone_id'],
                    'number' => $row['number'],
                    'phone_main' => $row['phone_main']
                );

                    /** Проверка на избежания повторения записей*/
                    if (in_array($row["id"], $uniqueData['profile_id']))
                    {
                        if (!in_array($row["email_id"], $uniqueData['email_id']))
                        {
                            $profiles[$row["id"]]->addEmail($email);
                            $uniqueData['email_id'][] = $row["email_id"];

                        }
                        if (!in_array($row["phone_id"], $uniqueData['phone_id']))
                        {
                            $profiles[$row["id"]]->addPhone($phone);
                            $uniqueData['phone_id'][] = $row["phone_id"];
                        }
                    }
                    else
                    {
                        $profile = new Profile($row['first_name'], $row['patronymic'],
                            $row['last_name'], $email, $phone, $row["id"]);

                        $profiles[$row["id"]] = $profile;

                        $uniqueData['profile_id'][] = $row["id"];
                        $uniqueData['email_id'][] = $row["email_id"];
                        $uniqueData['phone_id'][] = $row["phone_id"];
                    }
                }
            }
            $mysqli->close();
            return $profiles;
        }
}
