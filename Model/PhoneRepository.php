<?php


namespace Model;

require_once __DIR__ . '/Database.php';

/**
 * Class PhoneRepository
 * @package Model
 */
class PhoneRepository
{

    /**
     * @param Phone $phone
     * @return Phone
     */
    public function add(Phone $phone)
    {
        $clearParameters = array(
            "number" => $phone->getNumber(),
            "isMain" => $phone->getIsMain()
        );

        foreach ($clearParameters as $key => $clearParameter)
        {
            $clearParameters[$key] = Database::escape_string($clearParameter);
        }

        $queryAddPhone =<<<SQL
        INSERT INTO phone VALUES(NULL, '{$clearParameters['number']}')
SQL;

        $resultId = NULL;

        if(Database::query($queryAddPhone)) {
            $resultId = Database::insert_id();
        }
        else
        {
            die(Database::error());
        }

        return new Phone($clearParameters["number"], $clearParameters["isMain"], $resultId);
    }

    /**
     * @param Profile $profile
     * @param Phone $phone
     */
    public function addToExistingProfile(Profile $profile, Phone $phone)
    {
        $clearParameters = array(
            "profileId" => $profile->getId(),
            "number" => $phone->getNumber(),
            "isMain" => intval($phone->getIsMain())
        );

        foreach ($clearParameters as $key => $clearParameter)
        {
            $clearParameters[$key] = Database::escape_string($clearParameter);
        }

        $query = array(
            'AddPhone' => "INSERT INTO phone VALUES(NULL, '{$clearParameters['number']}')",
            'IsNotMainPhone' => NULL,
            'AddProfilePhone' => NULL
        );

        $result = array(
            "phoneId" => NULL,
            "phone" => NULL,
            "isMain" => NULL
        );

        if(Database::query($query['AddPhone'])) {
            $result["phoneId"] = Database::insert_id();
        }
        else
        {
            die(Database::error());
        }

        $query['IsNotMainPhone'] = <<<SQL
        UPDATE profile_phone SET is_main = 0
        WHERE profile_id = '{$clearParameters['profileId']}' AND is_main = 1
SQL;
        $query['AddProfilePhone'] =<<<SQL
        INSERT INTO profile_phone VALUES(
        NULL, '{$clearParameters['profileId']}', 
        '{$result['phoneId']}', '{$clearParameters['isMain']}')
SQL;


        if ($clearParameters['isMain'] == 1)
        {
            if(Database::query($query['IsNotMainPhone']))
            {
                Database::query($query['AddProfilePhone']) or die(Database::error());
            }
        }
        else
        {
            Database::query($query['AddProfilePhone']) or die(Database::error());
        }
    }

    /**
     * @param $phoneId
     */
    public function deleteById($phoneId)
    {
        $phoneId = Database::escape_string($phoneId);

        $queriesDeleteProfile = array(
            "number" => "DELETE FROM phone WHERE id = $phoneId",
            "profile_phone" => "DELETE FROM profile_phone WHERE phone_id = $phoneId"
        );

        foreach ($queriesDeleteProfile as $query)
        {
            Database::query($query) or die(Database::error());
        }
    }

    /**
     * @param Profile $profile
     * @param phone $phone
     */
    public function changeMainPhone(Profile $profile, phone $phone)
    {
        $clearParameters = array(
            "profile_id" => $profile->getId(),
            "phone_id" => $phone->getId(),
            "isMain" => 1,
        );

        $query = array(
            'IsNotMainPhone' => "UPDATE profile_phone
            SET is_main = 0 WHERE profile_id = '{$clearParameters['profile_id']}' AND is_main = 1",
            'IsMainPhone' => NULL
        );

        Database::query($query['IsNotMainPhone']) or die(Database::error());

        $query['isMainPhone'] =<<<SQL
        UPDATE profile_phone SET is_main = 1 
        WHERE profile_id = '{$clearParameters['profile_id']}' AND phone_id = '{$clearParameters['phone_id']}'
SQL;

        if(Database::query($query['IsNotMainPhone']))
        {
            Database::query($query['isMainPhone']) or die(Database::error());
        }
    }
}