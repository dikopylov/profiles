<?php

namespace Model;

class Profile
{
    private $firstName;
    private $patronymic;
    private $lastName;
    private $email;
    private $phone;
    private $id;

    /**
     * @param string $firstName
     * @return string
     */
    public function setFirstName(string $firstName) : string
    {
        return $this->firstName = htmlentities($firstName);
    }
    public function getFirstName() : string
    {
        return $this->firstName;
    }

    public function setPatronymic($patronymic) : string
    {
        return $this->patronymic = htmlentities($patronymic);
    }
    public function getPatronymic() : string
    {
        return $this->patronymic;
    }

    public function setLastName($lastName) : string
    {
        return $this->lastName = htmlentities($lastName);
    }
    public function getLastName() : string
    {
        return $this->lastName;
    }

    /**
     * формат массива: (почта, является ли основным)
     * $email = (example@mail.com, TRUE)
     * @var $email - array
     * @return string;
     */
    public function setEmail($email) : array
    {
        return $this->email = htmlentities($email);
    }

    /**
     * @return mixed
     */
    public function getEmail() //: array
    {
        return $this->email;
    }

    /**
     * формат массива: (телефон, является ли основным)
     * $phone = (3823, FALSE)
     * @var $email - array
     * @return string;
     */
    public function setPhone($phone) : array
    {
        return $this->phone = htmlentities($phone);
    }
    public function getPhone()
    {
        return $this->phone;
    }

    public function setId($id)
    {
        return $this->id = $id;
    }
    public function getId()
    {
        return $this->id;
    }

    public function getMainEmail()
    {
            foreach ($this->email as $item)
            {
                return $item["email_main"] == 1 ? $item : NULL;
            }
}
    public function getMainPhone()
    {
        return count($this->phone) == 3 ? $this->phone['number'] :
            $this->phone[array_search("1" , array_column($this->phone, 'phone_main'))];
    }

    function __construct($firstName, $patronymic, $lastName, $email, $phone, $id = NULL)
    {
        $this->id = htmlentities($id);
        $this->firstName = htmlentities($firstName);
        $this->patronymic = htmlentities($patronymic);
        $this->lastName = htmlentities($lastName);
        $this->email[] = $email;
        $this->phone[] = $phone;
    }

    public function addEmail($DataEmail)
    {
        return $this->email[] = $DataEmail;
    }

    public function addPhone($DataPhone)
    {
        return $this->phone[] = $DataPhone;
    }

}