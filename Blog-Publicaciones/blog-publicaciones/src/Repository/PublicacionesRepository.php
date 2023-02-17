<?php

namespace App\Repository;

use App\Entity\Publicaciones;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Publicaciones>
 *
 * @method Publicaciones|null find($id, $lockMode = null, $lockVersion = null)
 * @method Publicaciones|null findOneBy(array $criteria, array $orderBy = null)
 * @method Publicaciones[]    findAll()
 * @method Publicaciones[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PublicacionesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Publicaciones::class);
    }

    public function add(Publicaciones $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Publicaciones $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function getPublicacionesUser($trabajadorId): ?array
    {
        
        $strSql = "SELECT publicacione.id,
        publicacione.titulo,
        publicacione.cuerpo,
        publicacione.fechacreacion,
        categorias.nomCategorias,
        userTrabajador.nombres,
        userTrabajador.apellidos,
        publicacione.descripcion
        FROM App\Entity\Publicaciones publicacione
        LEFT JOIN App\Entity\User userTrabajador
        WITH publicacione.trabajadorId = userTrabajador.id
        LEFT JOIN App\Entity\Categorias categorias
        WITH publicacione.categoriaId = categorias.id
        WHERE publicacione.trabajadorId = :trabajador";

        return $this->_em->createQuery($strSql)
            ->setParameter('trabajador',$trabajadorId)
            ->getResult();
            
        
    }

    public function getPublicaciones(): ?array
{
    $strSql = "SELECT publicacione.id,
        publicacione.titulo,
        publicacione.cuerpo,
        publicacione.fechacreacion,
        categorias.nomCategorias,
        userTrabajador.nombres,
        userTrabajador.apellidos,
        publicacione.descripcion,
        publicacione.trabajadorId
        FROM App\Entity\Publicaciones publicacione
        LEFT JOIN App\Entity\User userTrabajador
        WITH publicacione.trabajadorId = userTrabajador.id
        LEFT JOIN App\Entity\Categorias categorias
        WITH publicacione.categoriaId = categorias.id";

    return $this->_em->createQuery($strSql)->getResult();
}
public function getPublicacionesConComentarios(): ?array
{
    $strSql = "SELECT publicacione.id,
        publicacione.titulo,
        publicacione.cuerpo,
        publicacione.fechacreacion,
        categorias.nomCategorias,
        userTrabajador.nombres,
        userTrabajador.apellidos,
        publicacione.descripcion,
        publicacione.trabajadorId,
        comentarios.id AS comentarioId,
        comentarios.body AS comentarioBody,
        comentarios.userId AS comentarioUserId,
        comentarios.fecreacion AS comentarioFecreacion
        FROM App\Entity\Publicaciones publicacione
        LEFT JOIN App\Entity\User userTrabajador
        WITH publicacione.trabajadorId = userTrabajador.id
        LEFT JOIN App\Entity\Categorias categorias
        WITH publicacione.categoriaId = categorias.id
        LEFT JOIN App\Entity\Comentarios comentarios
        WITH comentarios.publicacionesId = publicacione.id";

    return $this->_em->createQuery($strSql)->getResult();
}







//    /**
//     * @return Publicaciones[] Returns an array of Publicaciones objects
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

//    public function findOneBySomeField($value): ?Publicaciones
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
