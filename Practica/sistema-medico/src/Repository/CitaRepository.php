<?php

namespace App\Repository;

use App\Entity\Cita;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Cita>
 *
 * @method Cita|null find($id, $lockMode = null, $lockVersion = null)
 * @method Cita|null findOneBy(array $criteria, array $orderBy = null)
 * @method Cita[]    findAll()
 * @method Cita[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CitaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Cita::class);
    }

    public function save(Cita $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Cita $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return Cita[] Returns an array of Cita objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Cita
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }


 
    

    public function getCitasSuscritos($userId): ?array
    {
        $strSql = "SELECT cita.id, cita.Fecha,cita.TipoCita,userInst.Nombres
                    FROM App\Entity\Cita cita
                    JOIN App\Entity\User userEst
                    WITH cita.userId = userEst.id
                    JOIN App\Entity\Test cap
                    WITH cita.id = cap.citaId
                    JOIN App\Entity\User userInst
                    With cap.userId = userInst.id
                    WHERE cap.userId = :paciente";
        return $this->_em->createQuery($strSql)
            
            ->setParameter('paciente',$userId)
            ->getResult();
        ;
    }

    public function getCitasDisponibles($userId): ?array
    {
        $strSql = "SELECT cita.id, cita.Fecha,cita.TipoCita, user.Nombres
                    FROM App\Entity\Cita cita
                    JOIN App\Entity\User user
                    With cita.userId = user.id
                    WHERE  cita.id NOT IN (
                        SELECT test.citaId
                        FROM App\Entity\Test test
                        WHERE test.userId = :paciente
                    )";
        return $this->_em->createQuery($strSql)
            
            ->setParameter('paciente',$userId)
            ->getResult();
        ;
    }
}







