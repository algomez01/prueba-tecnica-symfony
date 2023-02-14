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

    public function add(Cita $entity, bool $flush = false): void
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
public function getCitaUser($userId): ?array
    {
        //se hace un left join para obtner las citas aún cuando no tengan registrado un medicoId
        $strSql = "SELECT cita.id,
        cita.fecha_creacion,
        cita.descripcion,
        cita.estado,
        tipoCita.descripcion descripcionTipoCita,
        userDoctor.nombres ,
        userDoctor.apellidos 
                    FROM App\Entity\Cita cita
                    LEFT JOIN App\Entity\User userDoctor
                    WITH cita.doctorId = userDoctor.id
                    LEFT JOIN App\Entity\TipoCita tipoCita
                    WITH cita.tipoCitaId = tipoCita.id
                    WHERE cita.pacienteId = :paciente";
        return $this->_em->createQuery($strSql)
            ->setParameter('paciente',$userId)
            ->getResult();
        
    }

    public function getCitasMedico($medico): ?array
    {
        //se hace un left join para obtner las citas aún cuando no tengan registrado un medicoId
        $strSql = "SELECT cita.id,
        cita.fecha_creacion,
        cita.descripcion,
        cita.estado,
        tipoCita.descripcion descripcionTipoCita,
        tipoCita.valor valorCita,
        userDoctor.nombres nom_doctor,
        userDoctor.apellidos apell_doctor,
        userPaciente.nombres nom_paciente,
        userPaciente.apellidos apell_paciente
                    FROM App\Entity\Cita cita
                    JOIN App\Entity\User userPaciente
                    WITH cita.pacienteId = userPaciente.id
                    LEFT JOIN App\Entity\User userDoctor
                    WITH cita.doctorId = userDoctor.id
                    LEFT JOIN App\Entity\TipoCita tipoCita
                    WITH cita.tipoCitaId = tipoCita.id
                    WHERE cita.doctorId = :medico"; //Where para filtrar los resultados

        

        $query = $this->_em->createQuery($strSql)
        ->setParameter('medico',$medico);
                
        return $query->getResult();
        ;
    }


    public function getCitaEstado($estado,$medico = null): ?array
    {
        //se hace un left join para obtner las citas aún cuando no tengan registrado un medicoId
        $strSql = "SELECT cita.id,
        cita.fecha_creacion,
        cita.descripcion,
        cita.estado,
        tipoCita.descripcion descripcionTipoCita,
        tipoCita.valor valorCita,
        userDoctor.nombres nom_doctor,
        userDoctor.apellidos apellido_doctor,
        userPaciente.nombres nom_pacientes,
        userPaciente.apellidos apell_pacientes
                    FROM App\Entity\Cita cita
                    JOIN App\Entity\User userPaciente
                    WITH cita.pacienteId = userPaciente.id
                    LEFT JOIN App\Entity\User userDoctor
                    WITH cita.doctorId = userDoctor.id
                    LEFT JOIN App\Entity\TipoCita tipoCita
                    WITH cita.tipoCitaId = tipoCita.id
                    WHERE cita.estado = :estado"; //Where para filtrar los resultados

        //para filtrar por médico cuando se necesario
        if($medico != null){
            $strSql .= " AND cita.doctorId = :medico";
        }

        $query = $this->_em->createQuery($strSql)
        ->setParameter('estado',$estado);

        if($medico != null){
            $query->setParameter('medico',$medico);;
        }
                
        return $query->getResult();
        ;
    }


}
