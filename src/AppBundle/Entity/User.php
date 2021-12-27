<?php

namespace AppBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="user")
 */
class User extends BaseUser
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="pseudo", type="string", length=255)
     */
    protected $pseudo;

    /**
     * @var string
     *
     * @ORM\Column(name="bio", type="text", nullable=true)
     */
    protected $bio;

    /**
     * @var string
     *
     * @ORM\Column(name="phone", type="string", length=255, nullable=true)
     */
    protected $phone;

    /**
     * @var string
     *
     * @ORM\Column(name = "inscription_date", type="datetime", nullable=true)
     */
    protected $inscriptionDate;

    /**
     * @var string
     *
     * @ORM\Column(name="adress_line", type="string", length=255, nullable=true)
     */
    protected $adressLine;

    /**
     * @var string
     *
     * @ORM\Column(name="city", type="string", length=255, nullable=true)
     */
    protected $city;

    /**
     * @var string
     *
     * @ORM\Column(name="zip_code", type="string", length=255, nullable=true)
     */
    protected $zipCode;

    /**
     * @var string
     *
     * @ORM\Column(name="country", type="string", length=255, nullable=true)
     */
    protected $country;

    public function getId()
    {
        return $this->id;
    }

    public function getPseudo()
    {
        return $this->pseudo;
    }

    public function getBio()
    {
        return $this->bio;
    }

    public function getPhone()
    {
        return $this->phone;
    }

    public function getInscriptionDate()
    {
        return $this->inscriptionDate;
    }

    public function getAdressLine()
    {
        return $this->adressLine;
    }

    public function getCity()
    {
        return $this->city;
    }

    public function getZipCode()
    {
        return $this->zipCode;
    }

    public function getCountry()
    {
        return $this->country;
    }

    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    public function setPseudo($pseudo)
    {
        $this->pseudo = $pseudo;
        return $this;
    }

    public function setBio($bio)
    {
        $this->bio = $bio;
        return $this;
    }

    public function setPhone($phone)
    {
        $this->phone = $phone;
        return $this;
    }

    public function setInscriptionDate($inscriptionDate)
    {
        $this->inscriptionDate = $inscriptionDate;
        return $this;
    }

    public function setAdressLine($adressLine)
    {
        $this->adressLine = $adressLine;
        return $this;
    }

    public function setCity($city)
    {
        $this->city = $city;
        return $this;
    }

    public function setZipCode($zipCode)
    {
        $this->zipCode = $zipCode;
        return $this;
    }

    public function setCountry($country)
    {
        $this->country = $country;
        return $this;
    }

    public function __construct()
    {
        $this->inscriptionDate = new \DateTime('now');
        parent::__construct();
    }
}