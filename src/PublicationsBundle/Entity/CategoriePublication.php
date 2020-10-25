<?php

namespace PublicationsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * CategoriePublication
 *
 * @ORM\Table(name="categoriePublication")
 * @ORM\Entity(repositoryClass="PublicationsBundle\Repository\CategoriePublicationRepository")
 */
class CategoriePublication
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_cat", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id_cat;

    /**
     * @var string
     * @Assert\NotBlank()
     * @Assert\Type(type="string")
     * @ORM\Column(name="nomCat", type="string", length=255)
     */
    private $nomCat;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id_cat;
    }

    /**
     * Set nomCat
     *
     * @param string $nomCat
     *
     * @return CategoriePublication
     */
    public function setNomCat($nomCat)
    {
        $this->nomCat = $nomCat;

        return $this;
    }

    /**
     * Get nomCat
     *
     * @return string
     */
    public function getNomCat()
    {
        return $this->nomCat;
    }
}

