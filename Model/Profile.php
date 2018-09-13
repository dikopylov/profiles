<?php

namespace Model;

require_once __DIR__ . '/Email.php';
require_once __DIR__ . '/Phone.php';

/**
 * Class Profile
 * @package Model
 */
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

    /**
     * @return string
     */
    public function getFirstName() : string
    {
        return $this->firstName;
    }

    /**
     * @param $patronymic
     * @return string
     */
    public function setPatronymic($patronymic) : string
    {
        return $this->patronymic = htmlentities($patronymic);
    }

    /**
     * @return string
     */
    public function getPatronymic() : string
    {
        return $this->patronymic;
    }

    /**
     * @param $lastName
     * @return string
     */
    public function setLastName($lastName) : string
    {
        return $this->lastName = htmlentities($lastName);
    }

    /**
     * @return string
     */
    public function getLastName() : string
    {
        return $this->lastName;
    }

    /**
     * @param Email $email
     * @return array
     */
    public function setEmail(Email $email) : array
    {
        return array_push($this->email, $email);
    }

    /**
     * @return array
     */
    public function getEmail() : array
    {
        return $this->email;
    }

    /**
     * @param Phone $phone
     * @return array
     */
    public function setPhone(Phone $phone) : array
    {
        return array_push($this->phone, $phone);
    }

    /**
     * @return array
     */
    public function getPhone() : array
    {
        return $this->phone;
    }

    /**
     * @param $id
     * @return int
     */
    public function setId($id) : int
    {
        return $this->id = $id;
    }

    /**
     * @return int
     */
    public function getId() : int
    {
        return $this->id;
    }

    /**
     * @return Email
     */
    public function getMainEmail() : Email
    {
        foreach ($this->email as $email) {
            if ($email->getIsMain() == 1)
                return $email;
        }
    }

    /**
     * @return Phone
     */
    public function getMainPhone() : Phone
    {
        foreach ($this->phone as $phone)
        {
            if ($phone->getIsMain() == 1)
                return $phone;
        }
    }

    /**
     * Profile constructor.
     * @param $firstName
     * @param $patronymic
     * @param $lastName
     * @param Email $email
     * @param Phone $phone
     * @param null $id
     */
    function __construct($firstName, $patronymic, $lastName, Email $email, Phone $phone, $id = NULL)
    {
        $this->id = htmlentities($id);
        $this->firstName = htmlentities($firstName);
        $this->patronymic = htmlentities($patronymic);
        $this->lastName = htmlentities($lastName);
        $this->email[] = $email;
        $this->phone[] = $phone;
    }

    /**
     * @param Email $email
     * @return Email
     */
    public function addEmail(Email $email)
    {
        return $this->email[] = $email;
    }

    /**
     * @param Phone $phone
     * @return Phone
     */
    public function addPhone(Phone $phone)
    {
        return $this->phone[] = $phone;
    }

}