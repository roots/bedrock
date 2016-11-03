<?php
/**
 * Created by PhpStorm.
 * User: jeremydesvaux
 * Date: 17/10/2016
 * Time: 15:52
 */

namespace WonderWp\Plugin\Recette;


use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;

class RecetteRepository extends EntityRepository
{
    public function getFindByMetas($metas=array(),$filters=array(),$firstResult=0,$maxResult=24){

        $qb = $this->getEntityManager()->createQueryBuilder();

        $qb
            ->select('r')
            ->from(RecetteEntity::class, 'r');

        if(!empty($filters)){ foreach($filters as $key=>$val){
            $qb->andWhere('r.'.$key.' = (:r'.$key.'val)');
            $qb->setParameter('r'.$key.'val',$val);
        }}

        if(!empty($metas)){ foreach($metas as $metaKey=>$metaVal){
            $qb->join('r.metas','m'.$metaKey);
            $qb->andWhere('m'.$metaKey.'.val = (:m'.$metaKey.'val)');
            $qb->setParameter('m'.$metaKey.'val',$metaVal);
        }}

        $qb
            ->setFirstResult($firstResult)
            ->setMaxResults($maxResult);

        $pag = new Paginator($qb);
        return $pag;
    }

    public function getRandomRecipes($currentRecetteId,$limit=3){
        $qb = $this->getEntityManager()->createQueryBuilder();

        return $qb->select('r')
            ->from(RecetteEntity::class, 'r')
            ->where('r.id <> ?1')
            ->addSelect('RAND() as HIDDEN rand')
            ->orderBy('rand')
            ->setMaxResults($limit)
            ->setParameters(array(1 => $currentRecetteId))
            ->getQuery()
            ->getResult();
    }
}