<?php

namespace TGTBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Theme
 *
 * @ORM\Table(name="theme")
 * @ORM\Entity(repositoryClass="TGTBundle\Repository\ThemeRepository")
 */
class Theme
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
     * @ORM\Column(name="nomTheme", type="string", length=255)
     */
    private $nomTheme;

    /**
     * @var string
     *
     * @ORM\Column(name="TypeTheme", type="string", length=255)
     */
    private $typeTheme;

    /**
     * @var string
     *
     * @ORM\Column(name="LibelleTheme", type="string", length=255)
     */
    private $libelleTheme;

    /**
     * @var string
     *
     * @ORM\Column(name="DescriptionTheme", type="string", length=255)
     */
    private $descriptionTheme;


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
     * Set nomTheme
     *
     * @param string $nomTheme
     *
     * @return Theme
     */
    public function setNomTheme($nomTheme)
    {
        $this->nomTheme = $nomTheme;

        return $this;
    }

    /**
     * Get nomTheme
     *
     * @return string
     */
    public function getNomTheme()
    {
        return $this->nomTheme;
    }

    /**
     * Set typeTheme
     *
     * @param string $typeTheme
     *
     * @return Theme
     */
    public function setTypeTheme($typeTheme)
    {
        $this->typeTheme = $typeTheme;

        return $this;
    }

    /**
     * Get typeTheme
     *
     * @return string
     */
    public function getTypeTheme()
    {
        return $this->typeTheme;
    }

    /**
     * Set libelleTheme
     *
     * @param string $libelleTheme
     *
     * @return Theme
     */
    public function setLibelleTheme($libelleTheme)
    {
        $this->libelleTheme = $libelleTheme;

        return $this;
    }

    /**
     * Get libelleTheme
     *
     * @return string
     */
    public function getLibelleTheme()
    {
        return $this->libelleTheme;
    }

    /**
     * Set descriptionTheme
     *
     * @param string $descriptionTheme
     *
     * @return Theme
     */
    public function setDescriptionTheme($descriptionTheme)
    {
        $this->descriptionTheme = $descriptionTheme;

        return $this;
    }

    /**
     * Get descriptionTheme
     *
     * @return string
     */
    public function getDescriptionTheme()
    {
        return $this->descriptionTheme;
    }

    public function __toString()
    {
        return $this->getNomTheme();
    }


}

