<?php

namespace FormationsBundle\Repository;
use Doctrine\ORM\EntityRepository;

/**
 * formationRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class formationRepository extends EntityRepository
{
    public function trierDureeElv()
    {

        $query = $this->getEntityManager()

            ->createQuery("SELECT v from FormationsBundle:formation v ORDER BY v.dureeFormation DESC ");
        return $query->getResult();

    }
    public function trierDureeBas()
    {
        $query = $this->getEntityManager()
            ->createQuery("SELECT v from FormationsBundle:formation v ORDER BY v.dureeFormation ASC ");
        return $query->getResult();

    }
    public function RechercheTitreFormation($keyWord)
    {
        $query = $this->getEntityManager()->createQuery('SELECT v from FormationsBundle:formation v WHERE v.titreFormation LiKE :val')
            ->setParameter('val','%'.$keyWord.'%');

        return $query->getResult();

    }


}
