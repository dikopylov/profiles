<?php


namespace Model;

require_once __DIR__ . '/Database.php';

/**
 * Class EmailRepository
 * @package Model
 */
class EmailRepository
{
    /**
     * @param Email $email
     * @return Email
     */
    public function add(Email $email)
    {
        $clearParameters = array(
            "email" => $email->getEmail(),
            "isMain" => $email->getIsMain()
        );

        foreach ($clearParameters as $key => $clearParameter)
        {
            $clearParameters[$key] = Database::escape_string($clearParameter);
        }

        $queryAddEmail =<<<SQL
        INSERT INTO email VALUES(NULL, '{$clearParameters['email']}')
SQL;

        $resultId = NULL;

        if(Database::query($queryAddEmail)) {
            $resultId = Database::insert_id();
        }
        else
        {
            die(Database::error());
        }

        return new Email($clearParameters["email"], $clearParameters["isMain"], $resultId);
    }

    /**
     * @param Profile $profile
     * @param Email $email
     */
    public function addToExistingProfile(Profile $profile, Email $email)
    {
        $clearParameters = array(
            "profileId" => $profile->getId(),
            "email" => $email->getEmail(),
            "isMain" => intval($email->getIsMain())
        );

        foreach ($clearParameters as $key => $clearParameter)
        {
            $clearParameters[$key] = Database::escape_string($clearParameter);
        }

        $query = array(
            'AddEmail' =>"INSERT INTO email VALUES(NULL, '{$clearParameters['email']}')",
            'IsNotMainEMail' => NULL,
            'AddProfileEmail' => NULL
        );

        $resultEmailId = NULL;

        if(Database::query($query['AddEmail'])) {
            $resultEmailId = Database::insert_id();
        }
        else
        {
            die(Database::error());
        }

        $query['IsNotMainEMail'] =<<<SQL
        UPDATE profile_email
        SET is_main = 0 WHERE profile_id = '{$clearParameters['profileId']}' AND is_main = 1
SQL;
        $query['AddProfileEmail'] =<<<SQL
        INSERT INTO profile_email VALUES(
        NULL, '{$clearParameters['profileId']}', '$resultEmailId', '{$clearParameters['isMain']}')
        
SQL;

        if ($clearParameters['isMain'] == TRUE)
        {
            if(Database::query($query['IsNotMainEMail']))
            {
                Database::query($query['AddProfileEmail']) or die(Database::error());
            }
        }
        else
        {
            Database::query($query['AddProfileEmail']) or die(Database::error());
        }
    }

    /**
     * @param $emailId
     */
    public function deleteById($emailId)
    {
        $emailId = Database::escape_string($emailId);

        $queriesDeleteProfile = array(
            "email" => "DELETE FROM email WHERE id = $emailId",
            "profile_email" => "DELETE FROM profile_email WHERE email_id = $emailId"
        );

        foreach ($queriesDeleteProfile as $query)
        {
            Database::query($query) or die(Database::error());
        }
    }

    /**
     * @param Profile $profile
     * @param Email $email
     */
    public function changeMainEmail(Profile $profile, Email $email)
    {
        $clearParameters = array(
            "profile_id" => $profile->getId(),
            "email_id" => $email->getId(),
            "isMain" => 1,
        );

        $query = array(
            'IsNotMainEMail' => "UPDATE profile_email
            SET is_main = 0 WHERE profile_id = '{$clearParameters['profile_id']}' AND is_main = 1",
            'IsMainEMail' => NULL
        );

        Database::query($query['IsNotMainEMail']) or die(Database::error());

        $query['isMainEMail'] =<<<SQL
        UPDATE profile_email SET is_main = 1 
        WHERE profile_id = '{$clearParameters['profile_id']}' AND email_id = '{$clearParameters['email_id']}'
SQL;

        if(Database::query($query['IsNotMainEMail']))
        {
            Database::query($query['isMainEMail']) or die(Database::error());
        }
    }
}