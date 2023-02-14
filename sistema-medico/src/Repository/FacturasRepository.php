<?php

namespace App\Repository;

use App\Entity\Facturas;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Facturas>
 *
 * @method Facturas|null find($id, $lockMode = null, $lockVersion = null)
 * @method Facturas|null findOneBy(array $criteria, array $orderBy = null)
 * @method Facturas[]    findAll()
 * @method Facturas[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FacturasRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Facturas::class);
    }

    public function add(Facturas $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Facturas $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return Facturas[] Returns an array of Facturas objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('f.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Facturas
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
public function getFacturasUsuario($idUser): ?array
    {
        //se hace un left join para obtner las citas aún cuando no tengan registrado un medicoId
        $strSql = "SELECT fact.id,
        fact.fe_creacion fecha_factura,
        fact.total,
        cita.fe_creacion fecha_cita,
        tipoCita.descripcion descripcionTipoCita,
        CONCAT(CONCAT(userMedico.nombres,' '),userMedico.apellidos) nombres_medico,
        CONCAT(CONCAT(userPaciente.nombres,' '),userPaciente.apellidos) nombres_paciente
                    FROM App\Entity\Facturas fact
                    JOIN App\Entity\User userCajero
                    WITH fact.cajero_id = userCajero.id
                    JOIN App\Entity\Citas cita
                    WITH fact.cita_id = cita.id
                    JOIN App\Entity\TipoCita tipoCita
                    WITH cita.tipo_cita_id = tipoCita.id
                    JOIN App\Entity\User userPaciente
                    WITH cita.paciente_id = userPaciente.id
                    JOIN App\Entity\User userMedico
                    WITH cita.medico_id = userMedico.id
                    WHERE fact.cajero_id = :cajero";
        return $this->_em->createQuery($strSql)
            ->setParameter('cajero',$idUser)
            ->getResult();
        ;
    }

    public function getFacturasFechas($fechaInicio = null, $fechaFin = null): ?array
    {

        $strSql = "SELECT fact.id,
        fact.fe_creacion fecha_factura,
        fact.total,
        tipoCita.descripcion descripcionTipoCita,
        CONCAT(CONCAT(userCajero.nombres,' '),userCajero.apellidos) nombres_cajero
                    FROM App\Entity\Facturas fact
                    JOIN App\Entity\User userCajero
                    WITH fact.cajero_id = userCajero.id
                    JOIN App\Entity\Citas cita
                    WITH fact.cita_id = cita.id
                    JOIN App\Entity\TipoCita tipoCita
                    WITH cita.tipo_cita_id = tipoCita.id";

        //si le llegan las fechas, filtra
        if($fechaInicio != null && $fechaFin != null){
            $fechaInicio = new \DateTime($fechaInicio->format("Y-m-d")." 00:00:00");
            $fechaFin = new \DateTime($fechaFin->format("Y-m-d")." 23:59:59");

            $strCondicion = " AND fact.fe_creacion BETWEEN :fechaIni AND :fechaFin ";

            $strSql .= $strCondicion;
        }

        $query = $this->_em->createQuery($strSql);

        //si le llegan las fechas, setea parametros para filtrar
        if($fechaInicio != null && $fechaFin != null){
            $query->setParameter('fechaIni',$fechaInicio)
                ->setParameter('fechaFin',$fechaFin);
        }

        return $query->getResult();
    }

}
