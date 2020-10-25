<?php

namespace PublicationsBundle\Entity;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * Publication
 *
 * @ORM\Table(name="publication")
 * @ORM\Entity(repositoryClass="PublicationsBundle\Repository\PublicationRepository")
 */
class Publication
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_pub", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id_pub;

    /**
     * @var string
     *
     * @ORM\Column(name="contenu", type="string", length=2000)
     */
    private $contenue;

    /**
     * @var string
     *
     * @ORM\Column(name="video", type="string", length=255)
     */
    private $video;

    /**
     * @var string
     *
     * @ORM\Column(name="localisation", type="string", length=255)
     */
    private $localisation;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="datePub", type="datetime")
     */
    private $datePub;


    /**
     * @var float
     * @Assert\Type(type="float")
     * @Assert\Range(min="0",max="5")
     * @ORM\Column(name="ratingPub", type="float")
     */
    private $ratingPub;

    /**
     * @var CategoriePublication
     * @ORM\ManyToOne(targetEntity="PublicationsBundle\Entity\CategoriePublication")
     * @ORM\JoinColumn(name="id_cat",referencedColumnName="id_cat",onDelete="CASCADE")
     */
    private $categorie;

    /**
     * @ORM\OneToMany(targetEntity="PublicationsBundle\Entity\CommentairePublication",mappedBy="publication")
     * @var CommentairePublication[]
     */
    private $commentaires;

    /**
     * Publication constructor.
     */
    public function __construct()
    {
        $this->commentaires = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id_pub;
    }

    /**
     * Set contenue
     *
     * @param string $contenue
     *
     * @return Publication
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
     * Set video
     *
     * @param string $video
     *
     * @return Publication
     */
    public function setVideo($video)
    {
        $this->video = $video;

        return $this;
    }

    /**
     * Get video
     *
     * @return string
     */
    public function getVideo()
    {
        return $this->video;
    }

    /**
     * Set localisation
     *
     * @param string $localisation
     *
     * @return Publication
     */
    public function setLocalisation($localisation)
    {
        $this->localisation = $localisation;

        return $this;
    }

    /**
     * Get localisation
     *
     * @return string
     */
    public function getLocalisation()
    {
        return $this->localisation;
    }

    /**
     * Set datePub
     *
     * @param DateTime $datePub
     *
     * @return Publication
     */
    public function setDatePub($datePub)
    {
        $this->datePub = $datePub;

        return $this;
    }

    /**
     * Get datePub
     *
     * @return DateTime
     */
    public function getDatePub()
    {
        return $this->datePub;
    }


    /**
     * Set ratingPub
     *
     * @param float $ratingPub
     *
     * @return Publication
     */
    public function setRatingPub($ratingPub)
    {
        $this->ratingPub = $ratingPub;

        return $this;
    }

    /**
     * Get ratingPub
     *
     * @return float
     */
    public function getRatingPub()
    {
        return $this->ratingPub;
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

    /**
     * @return CommentairePublication[]
     */
    public function getCommentaires()
    {
        return $this->commentaires;
    }

    /**
     * @param CommentairePublication[] $commentaires
     */
    public function setCommentaires($commentaires)
    {
        $this->commentaires = $commentaires;
    }




    public function __toString()
    {
        return (string) $this->id_pub;
    }
}

