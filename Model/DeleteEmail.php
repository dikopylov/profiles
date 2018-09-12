<?php


namespace Model;

require_once __DIR__ . '/dataMysql.php';


class DeleteEmail
{
    private $profile;
    private $deleteEmailID;

    public function __construct($profile, $deleteEmailID)
    {
        $this->profile = $profile;
        $this->deleteEmailID = $deleteEmailID;
    }

    public function run()
    {
        $mysqli = new \mysqli(host, user,password,database);

        $clearParameters = array(
            "id" => is_null($this->profile->getId()) ? NULL : $this->profile->getId(),
            "email_id" => $this->deleteEmailID
        );

        foreach ($clearParameters as $key => $clearParameter)
        {
            $clearParameters[$key] = $mysqli->real_escape_string($clearParameter);
        }

        $queriesDeleteProfileEmail = "DELETE FROM profile_email WHERE profile_id = '{$clearParameters['id']}' AND is_main = 0";

        $queriesDeleteEmail = "DELETE FROM email WHERE id = ";

//        $email = $this->profile ? $this->profile->getEmail() : NULL;

        $mysqli->query($queriesDeleteEmail . $clearParameters['email_id']) or die($mysqli->error);
        $mysqli->query($queriesDeleteProfileEmail) or die($mysqli->error);



        $mysqli->close();
    }
}