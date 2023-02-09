<?php

namespace App\Repository;

use App\Entity\Cursos;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\ResultSetMapping;
use Doctrine\ORM\Query\ResultSetMappingBuilder;
use Doctrine\Persistence\ManagerRegistry;
use Exception;

/**
 * @extends ServiceEntityRepository<Cursos>
 *
 * @method Cursos|null find($id, $lockMode = null, $lockVersion = null)
 * @method Cursos|null findOneBy(array $criteria, array $orderBy = null)
 * @method Cursos[]    findAll()
 * @method Cursos[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CursosRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Cursos::class);
    }

    public function add(Cursos $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Cursos $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function getCursosSuscritos($idUser): ?array
    {
        $strSql = "SELECT cursos.id, cap.titulo, cap.descripcion, userInst.nombres, userInst.apellidos
                    FROM App\Entity\Cursos cursos
                    JOIN App\Entity\User userEst
                    WITH cursos.user_id = userEst.id
                    JOIN App\Entity\Capacitaciones cap
                    WITH cursos.capacitaciones_id = cap.id
                    JOIN App\Entity\User userInst
                    With cap.user_id = userInst.id
                    WHERE cap.estado = :estado
                    AND cursos.user_id = :estudiante";
        return $this->_em->createQuery($strSql)
            ->setParameter('estado','Activo')
            ->setParameter('estudiante',$idUser)
            ->getResult();
        ;
    }

    public function getCursosDisponibles($idUser): ?array
    {
        $strSql = "SELECT cap.id, cap.titulo, cap.descripcion, user.nombres, user.apellidos
                    FROM App\Entity\Capacitaciones cap
                    JOIN App\Entity\User user
                    With cap.user_id = user.id
                    WHERE cap.estado = :estado
                    AND cap.id NOT IN (
                        SELECT cursos.capacitaciones_id
                        FROM App\Entity\Cursos cursos
                        WHERE cursos.user_id = :estudiante
                    )";
        return $this->_em->createQuery($strSql)
            ->setParameter('estado','Activo')
            ->setParameter('estudiante',$idUser)
            ->getResult();
        ;
    }
}
