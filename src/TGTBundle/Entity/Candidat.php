<?php

namespace TGTBundle\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Candidat
 *
 * @ORM\Table(name="candidat")
 * @ORM\Entity(repositoryClass="TGTBundle\Repository\CandidatRepository")
 */
class Candidat
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
     * @ORM\ManyToOne(targetEntity=Casting::class, inversedBy="Candidat")
     * @ORM\JoinColumn(name="id_casting",referencedColumnName="id",  onDelete="CASCADE")
     */

    private $idcasting;

    /**
     * @var string
     * @Assert\NotBlank()
     * @ORM\Column(name="nomC", type="string", length=255)
     * @ORM\OneToMany(targetEntity=Entretien::class, cascade={"persist", "remove"}, mappedBy="Candidat" )
     */
    private $nomC;

    /**
     * @var int
     * @Assert\Length(max="8")
     * @Assert\Type(type="integer")
     * @ORM\Column(name="cinCondidat", type="integer", unique=true)
     */
    private $cinCondidat;

    /**
     * @var string
     * @Assert\File(mimeTypes={"application/pdf"})
     * @ORM\Column(name="cv", type="string", length=255)
     */
    private $cv;

    /**
     * @var string
     *
     * @ORM\Column(name="motivation", type="string", length=255)
     */
    private $motivation;

    /**
     * @var string
     *
     * @ORM\Column(name="mailaddress", type="string", length=255)
     */
    private $mailaddress;

    /**
     * @var int
     *
     * @ORM\Column(name="tel", type="integer")
     */
    private $tel;

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
     * @return mixed
     */
    public function getIdcasting()
    {
        return $this->idcasting;
    }

    /**
     * @param mixed $idcasting
     */
    public function setIdcasting($idcasting)
    {
        $this->idcasting = $idcasting;
    }

    /**
     * @return string
     */
    public function getNomC()
    {
        return $this->nomC;
    }

    /**
     * @param string $nomC
     */
    public function setNomC($nomC)
    {
        $this->nomC = $nomC;
    }

    /**
     * @return int
     */
    public function getCinCondidat()
    {
        return $this->cinCondidat;
    }

    /**
     * @param int $cinCondidat
     */
    public function setCinCondidat($cinCondidat)
    {
        $this->cinCondidat = $cinCondidat;
    }

    /**
     * @return string
     */
    public function getCv()
    {
        return $this->cv;
    }

    /**
     * @param string $cv
     */
    public function setCv($cv)
    {
        $this->cv = $cv;
    }

    /**
     * @return string
     */
    public function getMotivation()
    {
        return $this->motivation;
    }

    /**
     * @param string $motivation
     */
    public function setMotivation($motivation)
    {
        $this->motivation = $motivation;
    }

    /**
     * @return string
     */
    public function getMailaddress()
    {
        return $this->mailaddress;
    }

    /**
     * @param string $mailaddress
     */
    public function setMailaddress($mailaddress)
    {
        $this->mailaddress = $mailaddress;
    }

    /**
     * @return int
     */
    public function getTel()
    {
        return $this->tel;
    }

    /**
     * @param int $tel
     */
    public function setTel($tel)
    {
        $this->tel = $tel;
    }





    public function __toString()
    {
        return $this->getNomC();// TODO: Implement __toString() method.
    }
    public function __construct()
    {
        $this->nom = new ArrayCollection();
    }

}

