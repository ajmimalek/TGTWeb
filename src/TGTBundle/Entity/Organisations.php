<?php

namespace TGTBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Organisations
 *
 * @ORM\Table(name="organisations")
 * @ORM\Entity(repositoryClass="TGTBundle\Repository\OrganisationsRepository")
 */
class Organisations
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="NomOrganisation", type="string", length=255)
     */
    private $nomOrganisation;


    /**
     * @var string
     *
     * @ORM\Column(name="Apropos", type="string", length=5000)
     */
    private $apropos;

    /**
     * @ORM\OneToMany(targetEntity="Casting", mappedBy="Organisation_id")
     */
    private $castings;




    /**
     * @var string
     *
     * @ORM\Column(name="AdresseOrganisation", type="string", length=255)
     */
    private $adresseOrganisation;

    /**
     * @var int
     *
     * @Assert\Type(type="integer")
     * @ORM\Column(name="tel_organisation", type="integer")
     * @Assert\Length(
     *     max = 8,
     *     maxMessage = "Your phone number cannot be longer than {{ limit }} characters"
     * )
     */
    private $telOrganisation;

    /**
     * @var string
     *
     * @ORM\Column(name="Email_Org", type="string", length=255)
     * @Assert\Email(
     *     message = "The email '{{ value }}' is not a valid email."
     * )
     */
    private $emailOrganisation;

    /**
     * @var string
     *
     * @ORM\Column(name="LoginOrganisation", type="string", length=255)
     */
    private $loginOrganisation;

    /**
     * @var string
     *
     * @ORM\Column(name="PasswordOrganisation", type="string", length=255)
     */
    private $passwordOrganisation;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nomOrganisation
     *
     * @param string $nomOrganisation
     *
     * @return Organisations
     */
    public function setNomOrganisation($nomOrganisation)
    {
        $this->nomOrganisation = $nomOrganisation;

        return $this;
    }

    /**
     * @return string
     */
    public function getApropos()
    {
        return $this->apropos;
    }

    /**
     * @param string $apropos
     */
    public function setApropos($apropos)
    {
        $this->apropos = $apropos;
    }

    /**
     * Get nomOrganisation
     *
     * @return string
     */
    public function getNomOrganisation()
    {
        return $this->nomOrganisation;
    }

    /**
     * Set adresseOrganisation
     *
     * @param string $adresseOrganisation
     *
     * @return Organisations
     */
    public function setAdresseOrganisation($adresseOrganisation)
    {
        $this->adresseOrganisation = $adresseOrganisation;

        return $this;
    }

    /**
     * Get adresseOrganisation
     *
     * @return string
     */
    public function getAdresseOrganisation()
    {
        return $this->adresseOrganisation;
    }

    /**
     * Set telOrganisation
     *
     * @param integer $telOrganisation
     *
     * @return Organisations
     */
    public function setTelOrganisation($telOrganisation)
    {
        $this->telOrganisation = $telOrganisation;

        return $this;
    }

    /**
     * Get telOrganisation
     *
     * @return int
     */
    public function getTelOrganisation()
    {
        return $this->telOrganisation;
    }

    /**
     * Set emailOrganisation
     *
     * @param string $emailOrganisation
     *
     * @return Organisations
     */
    public function setEmailOrganisation($emailOrganisation)
    {
        $this->emailOrganisation = $emailOrganisation;

        return $this;
    }

    /**
     * Get emailOrganisation
     *
     * @return string
     */
    public function getEmailOrganisation()
    {
        return $this->emailOrganisation;
    }

    /**
     * Set loginOrganisation
     *
     * @param string $loginOrganisation
     *
     * @return Organisations
     */
    public function setLoginOrganisation($loginOrganisation)
    {
        $this->loginOrganisation = $loginOrganisation;

        return $this;
    }

    /**
     * Get loginOrganisation
     *
     * @return string
     */
    public function getLoginOrganisation()
    {
        return $this->loginOrganisation;
    }

    /**
     * Set passwordOrganisation
     *
     * @param string $passwordOrganisation
     *
     * @return Organisations
     */
    public function setPasswordOrganisation($passwordOrganisation)
    {
        $this->passwordOrganisation = $passwordOrganisation;

        return $this;
    }

    /**
     * Get passwordOrganisation
     *
     * @return string
     */
    public function getPasswordOrganisation()
    {
        return $this->passwordOrganisation;
    }

    public function __toString()
    {
        return $this->getNomOrganisation();// TODO: Implement __toString() method.
    }



    public function __construct()
    {
        $this->castings = new ArrayCollection();
    }




}

