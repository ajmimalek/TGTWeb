<?php

namespace FormationsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CategorieFormation
 *
 * @ORM\Table(name="categorie_formation")
 * @ORM\Entity(repositoryClass="FormationsBundle\Repository\CategorieFormationRepository")
 */
class CategorieFormation
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
     * @ORM\Column(name="libele", type="string", length=255)
     */
    private $libele;




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
     * Set libele
     *
     * @param string $libele
     *
     * @return CategorieFormation
     */
    public function setLibele($libele)
    {
        $this->libele = $libele;

        return $this;
    }

    /**
     * Get libele
     *
     * @return string
     */
    public function getLibele()
    {
        return $this->libele;
    }

    public function __toString()
    {
        return $this->getLibele();
    }


}

