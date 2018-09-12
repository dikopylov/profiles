<?php


namespace Model;

require_once __DIR__ . '/dataMysql.php';


class DeletePhone
{
    private $profile;
    private $deletePhoneID;

    public function __construct($profile, $deletePhoneID)
    {
        $this->profile = $profile;
        $this->deletePhoneID = $deletePhoneID;
    }

    public function run()
    {
        $mysqli = new \mysqli(host, user,password,database);

        $clearParameters = array(
            "id" => is_null($this->profile->getId()) ? NULL : $this->profile->getId(),
            "phone_id" => $this->deletePhoneID
        );
        foreach ($clearParameters as $key => $clearParameter)
        {
            $clearParameters[$key] = $mysqli->real_escape_string($clearParameter);
        }

        $queriesDeleteProfilePhone = "DELETE FROM profile_phone WHERE profile_id = '{$clearParameters['id']}' AND is_main = 0";

        $queriesDeletePhone = "DELETE FROM phone WHERE id = ";

        $mysqli->query($queriesDeletePhone . $clearParameters['phone_id']) or die($mysqli->error);
        $mysqli->query($queriesDeleteProfilePhone) or die($mysqli->error);



        $mysqli->close();
    }
}