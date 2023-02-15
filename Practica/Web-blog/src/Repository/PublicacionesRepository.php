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

    public function getCategoria($categoria): ?array
    {
        $strSql = "SELECT publi.titulo,
        publi.cuerpo,
        publi.estado,
        user.nombres,
        user.apellido,
        user.telefono,
        cate.nombre_categoria categoria
                FROM App\Entity\Publicaciones publi
                JOIN App\Entity\User user
                WITH publi.user_id = user.id
                JOIN App\Entity\Categorias cate
                WITH publi.categoria_id = cate.id
                WHERE publi.user_id = :categoria";

        return $this->_em->createQuery($strSql)
         //->setParameter('estado', 'Activo')
         ->setParameter('categoria', $categoria)
         ->getResult();
    }
}
