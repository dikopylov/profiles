<?php

namespace Model;

require_once __DIR__ . '/Profile.php';
require_once __DIR__ . '/Database.php';
require_once __DIR__ . '/../Controller/index.php';

/**
 * Class ProfileRepository
 * @package Model
 */
class ProfileRepository
{
    private $emailRepository;
    private $phoneRepository;

    /**
     * ProfileRepository constructor.
     * @param EmailRepository $emailRepository
     * @param PhoneRepository $phoneRepository
     */
    public function __construct(EmailRepository $emailRepository, PhoneRepository $phoneRepository)
    {
        $this->emailRepository = $emailRepository;
        $this->phoneRepository = $phoneRepository;

    }

    /**
     * @param Profile $profile
     */
    public function add(Profile $profile)
    {
        $clearParameters = array(
            "lastName" => $profile->getLastName(),
            "firstName" => $profile->getFirstName(),
            "patronymic" => $profile->getPatronymic(),
            "email" => $profile->getMainEmail()->getEmail(),
            "phone" => $profile->getMainPhone()->getNumber()
        );

        foreach ($clearParameters as $key => $clearParameter) {
            if (is_array($clearParameter))
            {
                /** для полей email, phone */
                foreach ($clearParameter as $clue => $clearParam)
                {
                    $clearParameters[$clue] = Database::escape_string($clearParam);
                }
            }
            else
            {
                $clearParameters[$key] = Database::escape_string($clearParameter);
            }
        }

        $queriesData = array(
            "profile" => "INSERT INTO profile VALUES(NULL, '{$clearParameters['firstName']}',
           '{$clearParameters['patronymic']}', '{$clearParameters['lastName']}')",
            "email" => "INSERT INTO email VALUES(NULL, '{$clearParameters['email']}')",
            "phone" => "INSERT INTO phone VALUES(NULL, '{$clearParameters['phone']}')"
            );

        $resultId = array();

        foreach ($queriesData as $key => $query)
        {
            if(Database::query($query))
            {
                $resultId[$key] = Database::insert_id();
            }
            else die(Database::error());
        }

        $queriesProfileContacts = array(
            "INSERT INTO profile_email VALUES(NULL, '{$resultId['profile']}', '{$resultId['email']}', TRUE)",
            "INSERT INTO profile_phone VALUES(NULL, '{$resultId['profile']}', '{$resultId['phone']}', TRUE)"
        );

        foreach ($queriesProfileContacts as $query)
        {
            Database::query($query) or die(Database::error());
        }

    }

    /**
     * @return array
     */
    public function getAll() : array
    {
        $queryJoin =<<<SQL
            SELECT profile.id, profile.first_name, profile.patronymic, profile.last_name,
            profile_email.email_id, profile_email.is_main AS email_main, 
            profile_phone.phone_id, profile_phone.is_main AS phone_main, 
            email.email, phone.number
            FROM ((((profile
            JOIN profile_email ON profile.id = profile_email.profile_id)
            JOIN profile_phone ON profile.id = profile_phone.profile_id)
            JOIN email on profile_email.email_id = email.id)
            JOIN phone on profile_phone.phone_id = phone.id)
SQL;

        $profiles = array();

        $uniqueData = array(
            'profile_id' => array(),
            'email_id' => array(),
            'phone_id' => array()
        );

        $resultJoin = NULL;

        if ($resultJoin = Database::query($queryJoin)) {
            while ($row = Database::fetch_assoc($resultJoin)) {

                $email = new Email($row['email'], $row['email_main'], $row['email_id']);

                $phone = new Phone($row['number'], $row['phone_main'], $row['phone_id']);

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

        return $profiles;

    }

    /**
     * @param $profileId
     */
    public function deleteById($profileId)
    {
          $profileId = Database::escape_string($profileId);

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
            Database::query($query) or die(Database::error());
        }

    }

    /**
     * @param Profile $profile
     */
    public function edit(Profile $profile)
    {
          $clearParameters = array(
            "id" => htmlentities($profile->getId()),
            "lastName" => htmlentities($profile->getLastName()),
            "firstName" => htmlentities($profile->getFirstName()),
            "patronymic" => htmlentities($profile->getPatronymic()),
            "email" => htmlentities($profile->getMainEmail()->getEmail()),
            "phone" => htmlentities($profile->getMainPhone()->getNumber())
        );

        foreach ($clearParameters as $key => $clearParameter)
        {
            $clearParameters[$key] = Database::escape_string($clearParameter);
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
            if(Database::query($query))
            {
                continue;
            }
            else die(Database::error());
        }
    }
}
