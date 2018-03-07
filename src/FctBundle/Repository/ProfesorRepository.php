<?php

namespace FctBundle\Repository;

use Doctrine\ORM\Tools\Pagination\Paginator;
/**
 * ProfesorRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ProfesorRepository extends \Doctrine\ORM\EntityRepository
{
    public function getPaginationProfesor($pageSize=5, $currentPage=1){
        $em = $this->getEntityManager();
        
        $dql = "SELECT a FROM FctBundle\Entity\Profesor a ORDER BY a.idProf DESC";
        
        $query = $em->createQuery($dql)
                ->setFirstResult($pageSize*($currentPage-1))
                ->setMaxResults($pageSize);
        
        $paginator = new Paginator($query, $fetchJoinCollection = true);
        return $paginator;
    }
}