<?php

namespace App\Repository;

use App\Data\SearchData;
use App\Entity\Participant;
use App\Entity\Sortie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Sortie>
 *
 * @method Sortie|null find($id, $lockMode = null, $lockVersion = null)
 * @method Sortie|null findOneBy(array $criteria, array $orderBy = null)
 * @method Sortie[]    findAll()
 * @method Sortie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SortieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Sortie::class);
    }

    public function save(Sortie $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Sortie $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return Sortie[] Returns an array of Sortie objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Sortie
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
    public function findSearch(SearchData $searchData, Participant $user)
    {
        $queryBuilder = $this->createQueryBuilder('c')
            ->leftJoin('c.participants', 'p');

        if ($searchData->inscrit) {
            $queryBuilder->andWhere(':user MEMBER OF c.participants')
                ->setParameter('user', $user);
        }
        if ($searchData->orga) {
            $queryBuilder->andWhere(':user = c.organiseePar')
                ->setParameter('user', $user);
        }

        if ($searchData->passe) {
            $queryBuilder->andWhere('c.dateHeureDebut < :now')
                ->setParameter('now', new \DateTime());
        }

        if ($searchData->noninscrit) {
            $queryBuilder->andWhere(':user NOT MEMBER OF c.participants')
                ->setParameter('user', $user);
        }
        if (!empty($searchData->datemin) && !empty($searchData->datemax)) {
            $queryBuilder
                ->andWhere('c.dateHeureDebut BETWEEN :datemin AND :datemax')
                ->setParameter('datemin', $searchData->datemin)
                ->setParameter('datemax', $searchData->datemax);
        }

        if (!empty($searchData->categories)) {
            $queryBuilder
                ->join('c.campus', 'campus')
                ->andWhere('c.campus IN (:categories)')
                ->setParameter('categories', $searchData->categories);
        }

        if ($searchData->q) {
            $queryBuilder->andWhere('c.nom LIKE :q')
                ->setParameter('q', '%' . $searchData->q . '%');
        }

        $result = $queryBuilder->getQuery()->getResult();

        if (empty($result)) {
            return 'pas de sortie actuellement avec ce campus';
        }

        return $result;
    }
}
