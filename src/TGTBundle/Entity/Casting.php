<?php

namespace TGTBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Casting
 *
 * @ORM\Table(name="casting")
 * @ORM\Entity(repositoryClass="TGTBundle\Repository\CastingRepository")
 */
class Casting
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
     *
     * @ORM\ManyToOne(targetEntity="Organisations",inversedBy="castings")
     * @ORM\JoinColumn(name="organisation_id",referencedColumnName="id")
     *
     */
    private $Organisation_id;

    /**
     * @var string
     *
     * @ORM\Column(name="TitreCasting", type="string", length=255)
     */
    private $titreCasting;

    /**
     * @var string
     *
     * @ORM\Column(name="DescriptionCasting", type="string", length=5000)
     */
    private $descriptionCasting;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="DateCasting", type="date")
     */
    private $dateCasting;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="DateLP", type="date")
     */
    private $dateLP;

    /**
     * @var string
     *
     * @ORM\Column(name="AdresseCasting", type="string", length=255)
     */
    private $adresseCasting;

    /**
     * @var string
     *
     * @ORM\Column(name="ImageCasting", type="string", length=255)
     */
    private $imageCasting;

    /**
     * @var string
     *
     * @ORM\Column(name="ThemeCasting", type="string", length=255)
     */
    private $themeCasting;

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
     * Set titreCasting
     *
     * @param string $titreCasting
     *
     * @return Casting
     */
    public function setTitreCasting($titreCasting)
    {
        $this->titreCasting = $titreCasting;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getOrganisationId()
    {
        return $this->Organisation_id;
    }

    /**
     * @param mixed $Organisation_id
     */
    public function setOrganisationId($Organisation_id)
    {
        $this->Organisation_id = $Organisation_id;
    }

    /**
     * @return string
     */
    public function getThemeCasting()
    {
        return $this->themeCasting;
    }

    /**
     * @param string $themeCasting
     */
    public function setThemeCasting($themeCasting)
    {
        $this->themeCasting = $themeCasting;
    }

    /**
     * Get titreCasting
     *
     * @return string
     */
    public function getTitreCasting()
    {
        return $this->titreCasting;
    }

    /**
     * Set descriptionCasting
     *
     * @param string $descriptionCasting
     *
     * @return Casting
     */
    public function setDescriptionCasting($descriptionCasting)
    {
        $this->descriptionCasting = $descriptionCasting;

        return $this;
    }

    /**
     * Get descriptionCasting
     *
     * @return string
     */
    public function getDescriptionCasting()
    {
        return $this->descriptionCasting;
    }

    /**
     * Set dateCasting
     *
     * @param \DateTime $dateCasting
     *
     * @return Casting
     */
    public function setDateCasting($dateCasting)
    {
        $this->dateCasting = $dateCasting;

        return $this;
    }

    /**
     * Get dateCasting
     *
     * @return \DateTime
     */
    public function getDateCasting()
    {
        return $this->dateCasting;
    }

    /**
     * Set dateLP
     *
     * @param \DateTime $dateLP
     *
     * @return Casting
     */
    public function setDateLP($dateLP)
    {
        $this->dateLP = $dateLP;

        return $this;
    }

    /**
     * Get dateLP
     *
     * @return \DateTime
     */
    public function getDateLP()
    {
        return $this->dateLP;
    }

    /**
     * Set adresseCasting
     *
     * @param string $adresseCasting
     *
     * @return Casting
     */
    public function setAdresseCasting($adresseCasting)
    {
        $this->adresseCasting = $adresseCasting;

        return $this;
    }

    /**
     * Get adresseCasting
     *
     * @return string
     */
    public function getAdresseCasting()
    {
        return $this->adresseCasting;
    }

    /**
     * Set imageCasting
     *
     * @param string $imageCasting
     *
     * @return Casting
     */
    public function setImageCasting($imageCasting)
    {
        $this->imageCasting = $imageCasting;

        return $this;
    }

    /**
     * Get imageCasting
     *
     * @return string
     */
    public function getImageCasting()
    {
        return $this->imageCasting;
    }

    public function __toString()
    {
        return $this->getTitreCasting();// TODO: Implement __toString() method.
    }

}

