<?php

namespace PublicationsBundle\Repository;

use Doctrine\DBAL\DBALException;
use Doctrine\ORM\EntityRepository;

/**
 * CategoriePublicationRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CategoriePublicationRepository extends EntityRepository
{
    public function alterTable()
    {
        try {
            $query = $this->getEntityManager()->getConnection()->prepare("ALTER TABLE categoriePublication AUTO_INCREMENT = 1;")->execute();
        } catch (DBALException $e) {
            $message = $e->getMessage();
            echo "<script type='text/javascript'>alert('$message');</script>";
        }
    }
}
