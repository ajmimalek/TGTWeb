<?php

namespace TGTBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Events
 *
 * @ORM\Table(name="events")
 * @ORM\Entity(repositoryClass="TGTBundle\Repository\EventsRepository")
 */
class Events
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
     * @ORM\ManyToOne(targetEntity="Organisations")
     * @ORM\JoinColumn(name="organisation_id",referencedColumnName="id")
     */

    private $Organisation_id;

    /**
     * @var string
     *
     * @ORM\Column(name="TitreEvents", type="string", length=255)
     */
    private $titreEvents;

    /**
     * @var string
     *
     * @ORM\Column(name="DescriptionEvents", type="string", length=5000)
     */
    private $descriptionEvents;

    /**
     * @var string
     *
     * @ORM\Column(name="ThemeEvents", type="string", length=255)
     */
    private $themeEvents;

    /**
     * @var string
     *
     * @ORM\Column(name="AdresseEvents", type="string", length=255)
     */
    private $adresseEvents;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="DateEvents", type="datetime")
     */
    private $dateEvents;

    /**
     * @var float
     *
     * @ORM\Column(name="prixEvents", type="float")
     */
    private $prixEvents;

    /**
     * @Assert\File(mimeTypes={"image/JPG ", "image/PNG ", "image/JPEG"})
     * @var string
     *
     * @ORM\Column(name="ImageEvents", type="string", length=255)
     */
    private $imageEvents;


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
     * Set titreEvents
     *
     * @param string $titreEvents
     *
     * @return Events
     */
    public function setTitreEvents($titreEvents)
    {
        $this->titreEvents = $titreEvents;

        return $this;
    }

    /**
     * Get titreEvents
     *
     * @return string
     */
    public function getTitreEvents()
    {
        return $this->titreEvents;
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
     * Set descriptionEvents
     *
     * @param string $descriptionEvents
     *
     * @return Events
     */
    public function setDescriptionEvents($descriptionEvents)
    {
        $this->descriptionEvents = $descriptionEvents;

        return $this;
    }

    /**
     * Get descriptionEvents
     *
     * @return string
     */
    public function getDescriptionEvents()
    {
        return $this->descriptionEvents;
    }

    /**
     * Set themeEvents
     *
     * @param string $themeEvents
     *
     * @return Events
     */
    public function setThemeEvents($themeEvents)
    {
        $this->themeEvents = $themeEvents;

        return $this;
    }

    /**
     * @return string
     */
    public function getImageEvents()
    {
        return $this->imageEvents;
    }

    /**
     * @param string $imageEvents
     */
    public function setImageEvents($imageEvents)
    {
        $this->imageEvents = $imageEvents;
    }

    /**
     * Get themeEvents
     *
     * @return string
     */
    public function getThemeEvents()
    {
        return $this->themeEvents;
    }

    /**
     * Set adresseEvents
     *
     * @param string $adresseEvents
     *
     * @return Events
     */
    public function setAdresseEvents($adresseEvents)
    {
        $this->adresseEvents = $adresseEvents;

        return $this;
    }

    /**
     * Get adresseEvents
     *
     * @return string
     */
    public function getAdresseEvents()
    {
        return $this->adresseEvents;
    }

    /**
     * Set dateEvents
     *
     * @param \DateTime $dateEvents
     *
     * @return Events
     */
    public function setDateEvents($dateEvents)
    {
        $this->dateEvents = $dateEvents;

        return $this;
    }

    /**
     * Get dateEvents
     *
     * @return \DateTime
     */
    public function getDateEvents()
    {
        return $this->dateEvents;
    }

    /**
     * Set prixEvents
     *
     * @param float $prixEvents
     *
     * @return Events
     */
    public function setPrixEvents($prixEvents)
    {
        $this->prixEvents = $prixEvents;

        return $this;
    }

    /**
     * Get prixEvents
     *
     * @return float
     */
    public function getPrixEvents()
    {
        return $this->prixEvents;
    }




    public function __toString()
    {
        return $this->getTitreEvents();
    }

}

