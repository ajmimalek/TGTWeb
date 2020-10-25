<?php

namespace TGTBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Contrat
 *
 * @ORM\Table(name="contrat")
 * @ORM\Entity(repositoryClass="TGTBundle\Repository\ContratRepository")
 */
class Contrat
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
     * @ORM\OneToOne(targetEntity="Casting")
     * @ORM\JoinColumn(name="id_casting",referencedColumnName="id")
     */

    private $id_casting;
    /**
     *
     * @ORM\OneToOne(targetEntity="Candidat")
     * @ORM\JoinColumn(name="id_candidat",referencedColumnName="id")
     */
    private $id_candidat;

    /**
     * @var float
     *
     * @ORM\Column(name="salaire", type="float")
     */
    private $salaire;

    /**
     * @var string
     *
     * @ORM\Column(name="typeContrat", type="string", length=255)
     */
    private $typeContrat;

    /**
     * @var string
     *
     * @ORM\Column(name="dureeContart", type="string", length=255)
     */
    private $dureeContart;


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
    public function getIdCasting()
    {
        return $this->id_casting;
    }

    /**
     * @param mixed $id_casting
     */
    public function setIdCasting($id_casting)
    {
        $this->id_casting = $id_casting;
    }

    /**
     * @return mixed
     */
    public function getIdCandidat()
    {
        return $this->id_candidat;
    }

    /**
     * @param mixed $id_candidat
     */
    public function setIdCandidat($id_candidat)
    {
        $this->id_candidat = $id_candidat;
    }

    /**
     * @return float
     */
    public function getSalaire()
    {
        return $this->salaire;
    }

    /**
     * @param float $salaire
     */
    public function setSalaire($salaire)
    {
        $this->salaire = $salaire;
    }

    /**
     * @return string
     */
    public function getTypeContrat()
    {
        return $this->typeContrat;
    }

    /**
     * @param string $typeContrat
     */
    public function setTypeContrat($typeContrat)
    {
        $this->typeContrat = $typeContrat;
    }

    /**
     * @return string
     */
    public function getDureeContart()
    {
        return $this->dureeContart;
    }

    /**
     * @param string $dureeContart
     */
    public function setDureeContart($dureeContart)
    {
        $this->dureeContart = $dureeContart;
    }



    public function __toString()
    {
        return (string) $this->getId(); // TODO: Implement __toString() method.
    }


}

