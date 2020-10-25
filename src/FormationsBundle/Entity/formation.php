<?php

namespace FormationsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * formation
 *
 * @ORM\Table(name="formation")
 * @ORM\Entity(repositoryClass="FormationsBundle\Repository\formationRepository")
 */
class formation
{
    /**
     * @var int
     *
     * @ORM\Column(name="formation_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $formation_id;

    /**
     * @var string
     *
     * @ORM\Column(name="titre_formation", type="string", length=255)
     * @Assert\Length(min = 5,
     *      max = 20,
     *      minMessage = "Your Title must be at least {{ limit }} characters long",
     *      maxMessage = "Your Title cannot be longer than {{ limit }} characters"
     * )
     */

    private $titreFormation;

    /**
     * @var string
     *
     * @ORM\Column(name="description_formation", type="string", length=255)
     * @Assert\Length(
     *      min = 5,
     *      max = 20,
     *      minMessage = "Your Description must be at least {{ limit }} characters long",
     *      maxMessage = "Your Description cannot be longer than {{ limit }} characters"
     * )
     */
    private $descriptionFormation;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=255)
     */
    private $image;

    /**
     * @var int
     *
     * @ORM\Column(name="duree_formation", type="integer")
     */
    private $dureeFormation;


    /**
     * @var int
     *
     * @ORM\Column(name="likes", type="integer")
     */
    private $likes;

    /**
     *
     * @ORM\ManyToOne(targetEntity="CategorieFormation")
     * @ORM\JoinColumn(name="id",referencedColumnName="id")
     */
    private $categorie;

    /**
     * @var int
     *
     * @ORM\Column(name="nolikes", type="integer")
     */
    private $nolikes;



    /**
     * @return int
     */
    public function getformationId()
    {
        return $this->formation_id;
    }

    /**
     * @param int $formation_id
     */
    public function setFormationId($formation_id)
    {
        $this->formation_id = $formation_id;
    }




    /**
     * Set titreFormation
     *
     * @param string $titreFormation
     *
     * @return formation
     */
    public function setTitreFormation($titreFormation)
    {
        $this->titreFormation = $titreFormation;

        return $this;
    }

    /**
     * Get titreFormation
     *
     * @return string
     */
    public function getTitreFormation()
    {
        return $this->titreFormation;
    }

    /**
     * Set descriptionFormation
     *
     * @param string $descriptionFormation
     *
     * @return formation
     */
    public function setDescriptionFormation($descriptionFormation)
    {
        $this->descriptionFormation = $descriptionFormation;

        return $this;
    }

    /**
     * Get descriptionFormation
     *
     * @return string
     */
    public function getDescriptionFormation()
    {
        return $this->descriptionFormation;
    }

    /**
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param string $image
     */
    public function setImage($image)
    {
        $this->image = $image;
    }


    /**
     * Set dureeFormation
     *
     * @param integer $dureeFormation
     *
     * @return formation
     */
    public function setDureeFormation($dureeFormation)
    {
        $this->dureeFormation = $dureeFormation;

        return $this;
    }

    /**
     * Get dureeFormation
     *
     * @return int
     */
    public function getDureeFormation()
    {
        return $this->dureeFormation;
    }

    /**
     * @return int
     */
    public function getLikes()
    {
        return $this->likes;
    }

    /**
     * @param int $likes
     */
    public function setLikes($likes)
    {
        $this->likes = $likes;
    }

    /**
     * @return int
     */
    public function getNolikes()
    {
        return $this->nolikes;
    }

    /**
     * @param int $nolikes
     */
    public function setNolikes($nolikes)
    {
        $this->nolikes = $nolikes;
    }






    /**
     * @return mixed
     */
    public function getCategorie()
    {
        return $this->categorie;
    }

    /**
     * @param mixed $categorie
     */
    public function setCategorie($categorie)
    {
        $this->categorie = $categorie;
    }

    public function __toString()
    {
        // TODO: Implement __toString() method.
        return $this->getTitreFormation();
    }


}

