<?php

namespace FctBundle\Repository;


use Doctrine\ORM\Tools\Pagination\Paginator;
use FctBundle\Entity\Alumno;
/**
 * AlumnoRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class AlumnoRepository extends \Doctrine\ORM\EntityRepository
{
    public function getPaginationAlumno($pageSize=5, $currentPage=1){
        $em = $this->getEntityManager();
        
        $dql = "SELECT a FROM FctBundle\Entity\Alumno a ORDER BY a.idAlu DESC";
        
        $query = $em->createQuery($dql)
                ->setFirstResult($pageSize*($currentPage-1))
                ->setMaxResults($pageSize);
        
        $paginator = new Paginator($query, $fetchJoinCollection = true);
        return $paginator;
    }
}
