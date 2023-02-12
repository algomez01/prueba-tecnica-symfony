<?php

namespace App\Repository;

use App\Entity\Citas;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Citas>
 *
 * @method Citas|null find($id, $lockMode = null, $lockVersion = null)
 * @method Citas|null findOneBy(array $criteria, array $orderBy = null)
 * @method Citas[]    findAll()
 * @method Citas[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CitasRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Citas::class);
    }

    public function add(Citas $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Citas $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function getCitasUsuario($idUser): ?array
    {
        //se hace un left join para obtner las citas aún cuando no tengan registrado un medicoId
        $strSql = "SELECT citas.id,
        citas.fe_creacion,
        citas.motivo,
        citas.estado,
        tipoCita.descripcion descripcionTipoCita,
        userMedico.nombres nombre_medico,
        userMedico.apellidos apellido_medico
                    FROM App\Entity\Citas citas
                    LEFT JOIN App\Entity\User userMedico
                    WITH citas.medicoId = userMedico.id
                    LEFT JOIN App\Entity\TiposCitas tipoCita
                    WITH citas.tipoCitaId = tipoCita.id
                    WHERE citas.pacienteId = :paciente";
        return $this->_em->createQuery($strSql)
            ->setParameter('paciente',$idUser)
            ->getResult();
        ;
    }

    public function getCitasEstado($estado,$medico = null): ?array
    {
        //se hace un left join para obtner las citas aún cuando no tengan registrado un medicoId
        $strSql = "SELECT citas.id,
        citas.fe_creacion,
        citas.motivo,
        citas.estado,
        tipoCita.descripcion descripcionTipoCita,
        tipoCita.costo valorCita,
        userMedico.nombres nombre_medico,
        userMedico.apellidos apellido_medico,
        userPaciente.nombres paci_nombres,
        userPaciente.apellidos paci_apellidos
                    FROM App\Entity\Citas citas
                    JOIN App\Entity\User userPaciente
                    WITH citas.pacienteId = userPaciente.id
                    LEFT JOIN App\Entity\User userMedico
                    WITH citas.medicoId = userMedico.id
                    LEFT JOIN App\Entity\TiposCitas tipoCita
                    WITH citas.tipoCitaId = tipoCita.id
                    WHERE citas.estado = :estado"; //Where para filtrar los resultados

        //para filtrar por médico cuando se necesario
        if($medico != null){
            $strSql .= " AND citas.medicoId = :medico";
        }

        $query = $this->_em->createQuery($strSql)
        ->setParameter('estado',$estado);

        if($medico != null){
            $query->setParameter('medico',$medico);;
        }
                
        return $query->getResult();
        ;
    }

//    public function findOneBySomeField($value): ?Citas
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
