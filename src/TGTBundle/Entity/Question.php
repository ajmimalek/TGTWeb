<?php

namespace TGTBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * Question
 *
 * @ORM\Table(name="question")
 * @ORM\Entity(repositoryClass="TGTBundle\Repository\QuestionRepository")
 */
class Question
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
     * @ORM\ManyToOne(targetEntity="Theme")
     * @ORM\JoinColumn(name="Theme_id",referencedColumnName="id",onDelete="CASCADE")
     */

    private $Theme_id;


    /**
     * @var string
     * @Assert\NotBlank()
     * @ORM\Column(name="Contenu", type="string", length=255)
     */
    private $contenu;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateQuestion", type="datetime")
     */
    private $dateQuestion;

    /**
     * @var int
     *
     * @ORM\Column(name="LikeQuestion", type="integer")
     */
    private $likeQuestion;

    /**
     * @var int
     *
     * @ORM\Column(name="DislikeQuestion", type="integer")
     */
    private $dislikeQuestion;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }




    /**
     * Set contenu
     *
     * @param string $contenu
     *
     * @return Question
     */
    public function setContenu($contenu)
    {
        $this->contenu = $contenu;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getThemeId()
    {
        return $this->Theme_id;
    }

    /**
     * @param mixed $Theme_id
     */
    public function setThemeId($Theme_id)
    {
        $this->Theme_id = $Theme_id;
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
     * Set dateQuestion
     *
     * @param \DateTime $dateQuestion
     *
     * @return Question
     */
    public function setDateQuestion($dateQuestion)
    {
        $this->dateQuestion = $dateQuestion;

        return $this;
    }

    /**
     * Get dateQuestion
     *
     * @return \DateTime
     */
    public function getDateQuestion()
    {
        return $this->dateQuestion;
    }

    /**
     * Set likeQuestion
     *
     * @param integer $likeQuestion
     *
     * @return Question
     */
    public function setLikeQuestion($likeQuestion)
    {
        $this->likeQuestion = $likeQuestion;

        return $this;
    }

    /**
     * Get likeQuestion
     *
     * @return int
     */
    public function getLikeQuestion()
    {
        return $this->likeQuestion;
    }

    /**
     * Set dislikeQuestion
     *
     * @param integer $dislikeQuestion
     *
     * @return Question
     */
    public function setDislikeQuestion($dislikeQuestion)
    {
        $this->dislikeQuestion = $dislikeQuestion;

        return $this;
    }

    /**
     * Get dislikeQuestion
     *
     * @return int
     */
    public function getDislikeQuestion()
    {
        return $this->dislikeQuestion;
    }

    public function __toString()
    {
        return $this->getContenu();
    }


}

