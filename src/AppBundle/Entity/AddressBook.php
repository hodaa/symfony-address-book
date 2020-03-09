<?php

namespace  AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\File;
use Doctrine\Common\Collections\ArrayCollection;


/**
 * AppBundle\Entity\User
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\AddressBookRepository")
 * @ORM\Table(name="address_book")
 */

class AddressBook
{
    public function __construct()
    {
        $this->city = new ArrayCollection();
    }

    const NUMBER_OF_ITEMS = 10;

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
     * message = "First name should not be empty ."
     * )
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\NotBlank(
     *  message = "Last name should not be empty ."
     * )
     */
    private $lastName;

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\NotBlank(
     *      message = "Street should not be empty ."
     *     )
     */
    private $street;

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\Length(max = 5, min =5)
     *
     */
    private $zip;

    /**
     * @ORM\ManyToOne(targetEntity="City", inversedBy="address_book")
     * @ORM\JoinColumn(name="city_id", referencedColumnName="id")
     */
    private $city;

    /**
     * @ORM\Column(type="string", length=100)
     *  @Assert\NotBlank(
     *      message = "Country should not be empty ."
     *     )
     *
     * @Assert\Country
     **/


    private $country;
    /**
     * @ORM\Column(type="string", length=100)
     *  @Assert\NotBlank(
     *      message = "Phone Number should not be empty ."
     *     )
     * @Assert\Length(min = 8, max = 20, minMessage = "Phone Number is inavlid",
     *     maxMessage = "Phone Number is inavlid")
     */
    private $phoneNumber;

    /**
     * @ORM\Column(type="date", length=100)
     * @Assert\Date
     * @Assert\LessThan("today")
     */
    private $birthday;

    /**
     * @ORM\Column(type="string", length=100)
     *  @Assert\Email(
     *     message = "The email '{{ value }}' is not a valid email."
     * )
     *
     **/

    private $email;


    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     *
     *
     **/
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
     * @return AddressBook
     */
    public function setBirthday($birthday)
    {
        $this->birthday = $birthday;
        return $this;
    }

    /**
     * @param $email
     * @return $this
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    /**
     *
     * @param File $picture
     * @return $this
     */
    public function setPicture(string $picture)
    {
        $this->picture = $picture;

        return $this;
    }

    /**
     * @param $city_id
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
