<?php

namespace Model;

require_once __DIR__ . '/dataMysql.php';
require_once __DIR__ . '/Profile.php';

class ProfileRepository
{
    private $emailRepo;
    private $phoneRepo;

    /** Добавление объекта в репозиторий */
    public function add(Profile $profile)
    {
        $mysqli = new \mysqli(host, user,password,database);

        $clearParameters = array(
            "lastName" => $profile->getLastName(),
            "firstName" => $profile->getFirstName(),
            "patronymic" => $profile->getPatronymic(),
            "email" => $profile->getMainEmail(),
            "phone" => $profile->getMainPhone()
        );

        foreach ($clearParameters as $key => $clearParameter) {
            if (is_array($clearParameter))
            {
                /** для полей email, phone */
                foreach ($clearParameter as $clue => $clearParam)
                {
                    $clearParameters[$clue] = $mysqli->real_escape_string($clearParam);
                }
            }
            else
            {
                $clearParameters[$key] = $mysqli->real_escape_string($clearParameter);
            }
        }

        $queriesData = array(
            "profile" => "INSERT INTO profile VALUES(NULL, '{$clearParameters['lastName']}', '{$clearParameters['firstName']}',
           '{$clearParameters['patronymic']}')",
            "email" => "INSERT INTO email VALUES(NULL, '{$clearParameters['email']}')",
            "phone" => "INSERT INTO phone VALUES(NULL,  '{$clearParameters['phone']}')");

        /** @var INT $resultId - массив последних вставленных ID значений в БД */
        $resultId = array();

        foreach ($queriesData as $key => $query)
        {
            if($mysqli->query($query))
            {
                $resultId[$key] = $mysqli->insert_id;
            }
            else die($mysqli->error);
        }

        $queriesProfileContacts = array(
            "INSERT INTO profile_email VALUES(NULL, '{$resultId['profile']}', '{$resultId['email']}', TRUE)",
            "INSERT INTO profile_phone VALUES(NULL, '{$resultId['profile']}', '{$resultId['phone']}', TRUE)"
        );

        foreach ($queriesProfileContacts as $query)
        {
            $mysqli->query($query) or die($mysqli->error);
        }

        $mysqli->close();
    }

    /**
     * Вывод всех объектов из репозитория
     * @return Profile[]
     */
    public function getAll() : array
    {
        $mysqli = new \mysqli(host, user, password, database);
//        $queryJoin = <<<SQL
//SQL;

        $queryJoin = "SELECT profile.id, profile.first_name, profile.patronymic, profile.last_name,
            profile_email.email_id, profile_email.is_main AS email_main, 
            profile_phone.phone_id, profile_phone.is_main AS phone_main, 
            email.email, phone.number
            FROM ((((profile
            JOIN profile_email ON profile.id = profile_email.profile_id)
            JOIN profile_phone ON profile.id = profile_phone.profile_id)
            JOIN email on profile_email.email_id = email.id)
            JOIN phone on profile_phone.phone_id = phone.id)";

        /** @var Profile $profiles */
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

        if ($result['Join'] = $mysqli->query($queryJoin)) {

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

                /** Проверка для избежания повторения записей */
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

    /** Поиск объекта */
    public function findById($profileId)
    {
        $mysqli = new \mysqli(host, user, password, database);

        $profileId = mysqli_real_escape_string($mysqli, $profileId);

        $queryJoin = "SELECT profile.id, profile.first_name, profile.patronymic, profile.last_name,
            profile_email.email_id, profile_email.is_main AS email_main, 
            profile_phone.phone_id, profile_phone.is_main AS phone_main, 
            email.email, phone.number
            FROM ((((profile
            JOIN profile_email ON profile.id = profile_email.profile_id)
            JOIN profile_phone ON profile.id = profile_phone.profile_id)
            JOIN email on profile_email.email_id = email.id)
            JOIN phone on profile_phone.phone_id = phone.id)
            WHERE profile.id = $profileId";

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

        $profile = null;

        if ($result['Join'] = $mysqli->query($queryJoin)) {

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

                /** Проверка для избежания повторения записей */
                if (in_array($row["id"], $uniqueData['profile_id']))
                {
                    if (!in_array($row["email_id"], $uniqueData['email_id']))
                    {
                        $profile->addEmail($email);
                        var_dump($profile);
                        exit();
                        $uniqueData['email_id'][] = $row["email_id"];

                    }
                    if (!in_array($row["phone_id"], $uniqueData['phone_id']))
                    {
                        $profile->addPhone($phone);
                        $uniqueData['phone_id'][] = $row["phone_id"];
                    }
                }
                else
                {
                    $profile = new Profile($row['first_name'], $row['patronymic'],
                        $row['last_name'], $email, $phone, $row["id"]);

                    $uniqueData['profile_id'][] = $row["id"];
                    $uniqueData['email_id'][] = $row["email_id"];
                    $uniqueData['phone_id'][] = $row["phone_id"];
                }
            }
        }

        $mysqli->close();

        return $profile;
    }

    /** Удаление объекта */
    public function deleteById($profileId)
    {
        $mysqli = new \mysqli(host, user,password,database);

        $profileId = mysqli_real_escape_string($mysqli, $profileId);

        $queriesDeleteProfile = array(
            "email" => "DELETE FROM email WHERE id IN (SELECT profile_email.email_id FROM profile_email 
            WHERE profile_email.profile_id = $profileId)",
            "phone" => "DELETE FROM phone WHERE id IN (SELECT profile_phone.phone_id FROM profile_phone
            WHERE profile_phone.profile_id = $profileId)",
            "profile" => "DELETE FROM profile WHERE id = $profileId",
            "profile_phone" => "DELETE FROM profile_phone WHERE profile_id = $profileId",
            "profile_email" => "DELETE FROM profile_email WHERE profile_id = $profileId",
        );

        foreach ($queriesDeleteProfile as $query)
        {
            $mysqli->query($query) or die($mysqli->error);
        }

        $mysqli->close();
    }

    public function edit($profileId, $firstName, $patronymic, $lastName, $email, $phone)
    {
        $mysqli = new \mysqli(host, user,password,database);

        $clearParameters = array(
            "id" => htmlentities($profileId),
            "lastName" => htmlentities($lastName),
            "firstName" => htmlentities($firstName),
            "patronymic" => htmlentities($patronymic),
            "email" => htmlentities($email),
            "phone" => htmlentities($phone)
        );

        foreach ($clearParameters as $key => $clearParameter)
        {
            $clearParameters[$key] = $mysqli->real_escape_string($clearParameter);
        }

        $queriesUpdate = array(" UPDATE profile SET
            last_name = '{$clearParameters['lastName']}',
            first_Name = '{$clearParameters['firstName']}',
            patronymic = '{$clearParameters['patronymic']}'
            WHERE id = '{$clearParameters['id']}'",
            "UPDATE email SET email = '{$clearParameters['email']}'
            WHERE id IN (SELECT profile_email.email_id FROM profile_email
            WHERE profile_email.profile_id = '{$clearParameters['id']}' AND profile_email.is_main = 1)",
            "UPDATE phone SET number = '{$clearParameters['phone']}'
            WHERE id IN (SELECT profile_phone.phone_id FROM profile_phone
            WHERE profile_phone.profile_id = '{$clearParameters['id']}' AND profile_phone.is_main = 1)"
             );

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

//    public function __construct(EmailRepository $emailRepository, PhoneRepository $phonerepository)
//    {
//        $this->phoneRepo = $phoneRepository;
//
//    }
}
