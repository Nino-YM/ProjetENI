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
        $queryBuilder = $this->createQueryBuilder('c');
        $queryBuilder->leftJoin('c.participants', 'p');

        if (!empty($searchData->inscrit)) {
            $queryBuilder
                ->andWhere('p = :user')
                ->setParameter('user', $user);
        }

        if (!empty($searchData->noninscrit)) {
            $queryBuilder
                ->andWhere($queryBuilder->expr()->notIn('p', ':user'))
                ->setParameter('user', $user);
        }

        if (!empty($searchData->q)) {
            $queryBuilder
                ->andWhere('c.nom LIKE :q')
                ->setParameter('q', '%' . $searchData->q . '%');
        }


        return $queryBuilder->getQuery()->getResult();
    }






}
