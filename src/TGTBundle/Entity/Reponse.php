<?php

namespace TGTBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Reponse
 *
 * @ORM\Table(name="reponse")
 * @ORM\Entity(repositoryClass="TGTBundle\Repository\ReponseRepository")
 */
class Reponse
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
     * @ORM\ManyToOne(targetEntity="Question")
     * @ORM\JoinColumn(name="Quesion_id",referencedColumnName="id",onDelete="CASCADE")
     */

    private $Question_id;

    /**
     * @var string
     * @Assert\NotBlank()
     * @ORM\Column(name="ContenuReponse", type="string", length=255)
     */
    private $contenuReponse;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @var int
     *
     * @ORM\Column(name="likeReponce", type="integer")
     */
    private $likeReponce;

    /**
     * @var int
     *
     * @ORM\Column(name="dislikeReponse", type="integer")
     */
    private $dislikeReponse;


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
     * Set contenuReponse
     *
     * @param string $contenuReponse
     *
     * @return Reponse
     */
    public function setContenuReponse($contenuReponse)
    {
        $this->contenuReponse = $contenuReponse;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getQuestionId()
    {
        return $this->Question_id;
    }

    /**
     * @param mixed $Question_id
     */
    public function setQuestionId($Question_id)
    {
        $this->Question_id = $Question_id;
    }

    /**
     * Get contenuReponse
     *
     * @return string
     */
    public function getContenuReponse()
    {
        return $this->contenuReponse;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Reponse
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set likeReponce
     *
     * @param integer $likeReponce
     *
     * @return Reponse
     */
    public function setLikeReponce($likeReponce)
    {
        $this->likeReponce = $likeReponce;

        return $this;
    }

    /**
     * Get likeReponce
     *
     * @return int
     */
    public function getLikeReponce()
    {
        return $this->likeReponce;
    }

    /**
     * Set dislikeReponse
     *
     * @param integer $dislikeReponse
     *
     * @return Reponse
     */
    public function setDislikeReponse($dislikeReponse)
    {
        $this->dislikeReponse = $dislikeReponse;

        return $this;
    }

    /**
     * Get dislikeReponse
     *
     * @return int
     */
    public function getDislikeReponse()
    {
        return $this->dislikeReponse;
    }
}

