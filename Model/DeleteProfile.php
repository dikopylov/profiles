<?php


namespace Model;

require_once __DIR__ . '/dataMysql.php';
require_once __DIR__ . '/Profile.php';



class DeleteProfile
{
    private $profile;

    public function __construct($profile)
    {
        $this->profile = $profile;
    }

    public function run()
    {
        $mysqli = new \mysqli(host, user,password,database);


        $id = is_null($this->profile->getId()) ? NULL : $this->profile->getId();

        $queriesDeleteProfile = array(
            "profile" => "DELETE FROM profile WHERE id = $id",
            "profile_phone" => "DELETE FROM profile_phone WHERE profile_id = $id",
            "profile_email" => "DELETE FROM profile_email WHERE profile_id = $id"
        );

        $queriesDeleteContacts = array(
            "email" => "DELETE FROM email WHERE id = ",
            "phone" => "DELETE FROM phone WHERE id = "
        );

        $emails = $this->profile ? $this->profile->getEmail() : NULL;

        foreach ($emails as $email)
        {
            $mysqli->query($queriesDeleteContacts["email"] . $email["email_id"]) or die($mysqli->error);
        }
        $phones = $this->profile ? $this->profile->getPhone() : NULL;
        foreach ($phones as $phone)
        {
            $mysqli->query($queriesDeleteContacts["phone"] . $phone["phone_id"]) or die($mysqli->error);
        }



        foreach ($queriesDeleteProfile as $query)
        {
            $mysqli->query($query) or die($mysqli->error);
        }

        $mysqli->close();
    }
}