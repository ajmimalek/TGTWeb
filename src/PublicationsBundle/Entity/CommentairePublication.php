<?php

namespace PublicationsBundle\Entity;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * CommentairePublication
 *
 * @ORM\Table(name="commentairePublication")
 * @ORM\Entity(repositoryClass="PublicationsBundle\Repository\CommentairePublicationRepository")
 */
class CommentairePublication
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
     * @ORM\Column(name="contenu", type="string", length=2000)
     *
     * @Assert\Type(type="string")
     */
    private $contenu;


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
     * @ORM\ManyToOne(targetEntity="PublicationsBundle\Entity\Publication",inversedBy="commentaires")
     * @ORM\JoinColumn(name="id_pub",referencedColumnName="id_pub",onDelete="CASCADE")
     */
    private $publication;

    /**
     * @return mixed
     */
    public function getPublication()
    {
        return $this->publication;
    }

    /**
     * @param mixed $publication
     */
    public function setPublication($publication)
    {
        $this->publication = $publication;
    }

    public function __toString()
    {
        return (string) $this->publication;
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
     * @param string $contenu
     *
     * @return CommentairePublication
     */
    public function setContenu($contenu)
    {
        $this->contenu = $contenu;

        return $this;
    }

    /**
     * Get contenu
     *
     * @return string
     */
    public function getContenu()
    {
        return $this->contenu;
    }



    /**
     * Set nbinutile
     *
     * @param integer $nbinutile
     *
     * @return CommentairePublication
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
     * @return CommentairePublication
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
     * @return CommentairePublication
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

