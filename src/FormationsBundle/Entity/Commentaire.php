<?php

namespace FormationsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Commentaire
 *
 * @ORM\Table(name="commentaire")
 * @ORM\Entity(repositoryClass="FormationsBundle\Repository\CommentaireRepository")
 */
class Commentaire
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_comment", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id_comment;

    /**
     * @var string
     * @ORM\Column(name="contenue", type="string", length=2000)
     * @Assert\NotBlank()
     * @Assert\Type(type="string")
     */
    private $contenue;


    /**
     * @var int
     *
     * @Assert\Type(type="integer")
     * @ORM\Column(name="nbinutile", type="integer")
     */
    private $nbinutile;

    /**
     * @var integer
     * @Assert\Type(type="float")
     * @Assert\Range(min="0",max="5")
     * @ORM\Column(name="ratingComm", type="integer")
     */
    private $ratingComm;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateComm", type="datetime")
     */
    private $dateComm;
    /**
     * @ORM\ManyToOne(targetEntity="FormationsBundle\Entity\cour")
     * @ORM\JoinColumn(name="cour_id",referencedColumnName="cour_id",onDelete="CASCADE")
     */
    private $cour;

    /**
     * @return mixed
     */
    public function getCour()
    {
        return $this->cour;
    }

    /**
     * @param mixed $cour
     */
    public function setCour($cour)
    {
        $this->cour = $cour;
    }

    public function __toString()
    {
        return (string) $this->cour;
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id_comment;
    }

    /**
     * Set contenue
     *
     * @param string $contenue
     *
     * @return Commentaire
     */
    public function setContenue($contenue)
    {
        $this->contenue = $contenue;

        return $this;
    }

    /**
     * Get contenue
     *
     * @return string
     */
    public function getContenue()
    {
        return $this->contenue;
    }



    /**
     * Set nbinutile
     *
     * @param integer $nbinutile
     *
     * @return Commentaire
     */
    public function setNbinutile($nbinutile)
    {
        $this->nbinutile = $nbinutile;

        return $this;
    }

    /**
     * Get nbinutile
     *
     * @return int
     */
    public function getNbinutile()
    {
        return $this->nbinutile;
    }

    /**
     * Set ratingComm
     *
     * @param float $ratingComm
     *
     * @return Commentaire
     */
    public function setRatingComm($ratingComm)
    {
        $this->ratingComm = $ratingComm;

        return $this;
    }

    /**
     * Get ratingComm
     *
     * @return float
     */
    public function getRatingComm()
    {
        return $this->ratingComm;
    }

    /**
     * Set dateComm
     *
     * @param \DateTime $dateComm
     *
     * @return Commentaire
     */
    public function setDateComm($dateComm)
    {
        $this->dateComm = $dateComm;

        return $this;
    }

    /**
     * Get dateComm
     *
     * @return \DateTime
     */
    public function getDateComm()
    {
        return $this->dateComm;
    }
}