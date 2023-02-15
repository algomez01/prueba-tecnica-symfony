<?php

namespace App\Repository;

use App\Entity\Publicacion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Publicacion>
 *
 * @method Publicacion|null find($id, $lockMode = null, $lockVersion = null)
 * @method Publicacion|null findOneBy(array $criteria, array $orderBy = null)
 * @method Publicacion[]    findAll()
 * @method Publicacion[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PublicacionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Publicacion::class);
    }

    public function add(Publicacion $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Publicacion $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return Publicacion[] Returns an array of Publicacion objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Publicacion
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }

public function getPublicacionUser($trabajadorId): ?array
    {
        //se hace un left join para obtner las citas aún cuando no tengan registrado un medicoId
        $strSql = "SELECT publicacion.id,
        publicacion.Titulo,
        publicacion.descripcion,
        
        categoria.nomCategoria ,
        userTrabajador.nombres ,
        userTrabajador.apellidos 
                    FROM App\Entity\Publicacion publicacion
                    LEFT JOIN App\Entity\User userTrabajador
                    WITH publicacion.trabajadorId = userTrabajador.id
                    LEFT JOIN App\Entity\Categoria categoria
                    WITH publicacion.categoriaId = categoria.id
                    WHERE publicacion.trabajadorId = :trabajador";
        return $this->_em->createQuery($strSql)
            ->setParameter('trabajador',$trabajadorId)
            ->getResult();
        
    }
}
