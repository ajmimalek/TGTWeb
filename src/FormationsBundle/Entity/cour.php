<?php

namespace FormationsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * cour
 *
 * @ORM\Table(name="cour")
 * @ORM\Entity(repositoryClass="FormationsBundle\Repository\courRepository")
 */
class cour
{
    /**
     * @var int
     *
     * @ORM\Column(name="cour_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $cour_id;

    /**
     * @var string
     *
     * @ORM\Column(name="titre_cour", type="string", length=255)
     * * @Assert\Length(
     *      min = 5,
     *      max = 20,
     *      minMessage = "Your title must be at least {{ limit }} characters long",
     *      maxMessage = "Your title cannot be longer than {{ limit }} characters"
     * )
     */
    private $titreCour;

    /**
     * @var string
     *
     * @ORM\Column(name="description_cour", type="string", length=255)
     * @Assert\Length(
     *      min = 5,
     *      max = 20,
     *      minMessage = "Your Description must be at least {{ limit }} characters long",
     *      maxMessage = "Your Description cannot be longer than {{ limit }} characters"
     * )
     */
    private $descriptionCour;

    /**
     * @var int
     *
     * @ORM\Column(name="duree_cour", type="integer")
     */
    private $dureeCour;

    /**
     * @var int
     *
     * @ORM\Column(name="note_cour", type="integer")
     */
    private $noteCour;

    /**
     * @var string
     *
     * @ORM\Column(name="text_cour", type="string", length=255)
     */
    private $textCour;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=255)
     */
    private $image;



    /**
     *
     * @ORM\ManyToOne(targetEntity="formation")
     * @ORM\JoinColumn(name="formations_id",referencedColumnName="formation_id")
     */
    private $formations;

    /**
     * @return int
     */
    public function getCourId()
    {
        return $this->cour_id;
    }

    /**
     * @param int $cour_id
     */
    public function setCourId($cour_id)
    {
        $this->cour_id = $cour_id;
    }



    /**
     * Set titreCour
     *
     * @param string $titreCour
     *
     * @return cour
     */
    public function setTitreCour($titreCour)
    {
        $this->titreCour = $titreCour;

        return $this;
    }

    /**
     * Get titreCour
     *
     * @return string
     */
    public function getTitreCour()
    {
        return $this->titreCour;
    }

    /**
     * Set descriptionCour
     *
     * @param string $descriptionCour
     *
     * @return cour
     */
    public function setDescriptionCour($descriptionCour)
    {
        $this->descriptionCour = $descriptionCour;

        return $this;
    }

    /**
     * Get descriptionCour
     *
     * @return string
     */
    public function getDescriptionCour()
    {
        return $this->descriptionCour;
    }

    /**
     * Set dureeCour
     *
     * @param integer $dureeCour
     *
     * @return cour
     */
    public function setDureeCour($dureeCour)
    {
        $this->dureeCour = $dureeCour;

        return $this;
    }

    /**
     * Get dureeCour
     *
     * @return int
     */
    public function getDureeCour()
    {
        return $this->dureeCour;
    }

    /**
     * Set noteCour
     *
     * @param integer $noteCour
     *
     * @return cour
     */
    public function setNoteCour($noteCour)
    {
        $this->noteCour = $noteCour;

        return $this;
    }

    /**
     * Get noteCour
     *
     * @return int
     */
    public function getNoteCour()
    {
        return $this->noteCour;
    }

    /**
     * Set textCour
     *
     * @param string $textCour
     *
     * @return cour
     */
    public function setTextCour($textCour)
    {
        $this->textCour = $textCour;

        return $this;
    }

    /**
     * Get textCour
     *
     * @return string
     */
    public function getTextCour()
    {
        return $this->textCour;
    }

    /**
     * Set image
     *
     * @param string $image
     *
     * @return cour
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }


    public function __toString()
    {
        // TODO: Implement __toString() method.
        return $this->getTitreCour();
    }

    /**
     * @return mixed
     */
    public function getFormations()
    {
        return $this->formations;
    }

    /**
     * @param mixed $formations
     */
    public function setFormations($formations)
    {
        $this->formations = $formations;
    }


}

