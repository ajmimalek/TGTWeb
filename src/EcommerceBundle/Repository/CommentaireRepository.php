<?php

namespace EcommerceBundle\Repository;

/**
 * CommentaireRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CommentaireRepository extends \Doctrine\ORM\EntityRepository
{
    public function trierDate()
    {
        $query = $this->getEntityManager()
            ->createQuery("SELECT v from EcommerceBundle:Commentaire v ORDER BY v.date DESC ");
        return $query->getResult();

    }
}