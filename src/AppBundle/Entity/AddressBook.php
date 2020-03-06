<?php

namespace  AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\File;

/**
 * AppBundle\Entity\User
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\AddressBookRepository")
 * @ORM\Table(name="address_book")
 */

class AddressBook
{

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */

    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     *
     * @Assert\NotBlank(
     * message = "The first name should not be empty ."
     * )
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\NotBlank(
     *  message = "The last name should not be empty ."
     * )
     */
    private $lastName;

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\NotBlank
     */
    private $street;

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\Length(max = 5)
     *
     */
    private $zip;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $city;
    /**
     * @ORM\Column(type="string", length=100)
     */

    private $country;
    /**
     * @ORM\Column(type="string", length=100)
     */
    private $phoneNumber;
    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\Date
     * @var string A "Y-m-d" formatted value
     */
    private $birthday;

    /**
     * @ORM\Column(type="string", length=100)
     *  @Assert\Email(
     *     message = "The email '{{ value }}' is not a valid email."
     * )
     */
    private $email;


    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     * nulla
     */

    private $picture;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }
    /**
     * @return mixed
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @return mixed
     */
    public function getZip()
    {
        return $this->zip;
    }

    /**
     * @return mixed
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @return mixed
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @return mixed
     */
    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }

    /**
     * @return mixed
     */
    public function getBirthday()
    {
        return $this->birthday;
    }
    /**
     * @return mixed
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param $email
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return mixed
     */
    public function getPicture()
    {
        return $this->picture;
    }

    /**
     * @return mixed
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * @param $firstName
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    /**
     * @param $lastName
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    /**
     * @param $street
     */
    public function setStreet($street)
    {
        $this->street = $street;
    }

    /**
     * @param $zip
     */
    public function setZip($zip)
    {
        $this->zip = $zip;
    }

    /**
     * @param $birthday
     */
    public function setBirthday($birthday)
    {
        $this->birthday = $birthday;
    }

    /**
     * @param $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @param File $picture
     * @return $this
     */
    public function setPicture(string $picture)
    {
        $this->picture = $picture;

        return $this;
    }

    /**
     * @param $city
     */
    public function setCity($city)
    {
        $this->city = $city;
    }

    /**
     * @param $country
     */
    public function setCountry($country)
    {
        $this->country = $country;
    }

    /**
     * @param $phoneNumber
     */
    public function setPhoneNumber($phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;
    }
}
