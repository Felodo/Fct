<?php

namespace FctBundle\Repository;

use Doctrine\ORM\Tools\Pagination\Paginator;
/**
 * CursoRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CicloRepository extends \Doctrine\ORM\EntityRepository
{
    public function getPaginationCiclo($pageSize=5, $currentPage=1){
        $em = $this->getEntityManager();
        
        $dql = "SELECT a FROM FctBundle\Entity\Ciclo a ORDER BY a.idCiclo DESC";
        
        $query = $em->createQuery($dql)
                ->setFirstResult($pageSize*($currentPage-1))
                ->setMaxResults($pageSize);
        
        $paginator = new Paginator($query, $fetchJoinCollection = true);
        return $paginator;
    }
	
	public function getBuscarCiclo($filtros, $pageSize=5, $currentPage=1){
		$em = $this->getEntityManager();
		
		$dql = "SELECT a FROM FctBundle\Entity\Ciclo a";
		
		if(count($filtros) > 0) {
			$dql .= ' WHERE ' . implode(' and ', $filtros);
		}
		
		$query = $em->createQuery($dql)
                ->setFirstResult($pageSize*($currentPage-1))
                ->setMaxResults($pageSize);
        
        $paginator = new Paginator($query, $fetchJoinCollection = true);
        return $paginator;
	}
}