<?php

namespace App\Repository;

use App\Entity\Factura;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Factura>
 *
 * @method Factura|null find($id, $lockMode = null, $lockVersion = null)
 * @method Factura|null findOneBy(array $criteria, array $orderBy = null)
 * @method Factura[]    findAll()
 * @method Factura[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FacturaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Factura::class);
    }

    public function add(Factura $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Factura $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return Factura[] Returns an array of Factura objects
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

//    public function findOneBySomeField($value): ?Factura
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
    $strSql = "SELECT factura.id,
    factura.fecha_creacion fe_factura,
    factura.totalpagar,
    cita.fecha_creacion fe_cita,
    tipoCita.descripcion descripcionTipoCita,
    CONCAT(CONCAT(userDoctor.nombres,' '),userDoctor.apellidos) nom_doctor,
    CONCAT(CONCAT(userPaciente.nombres,' '),userPaciente.apellidos) nom_paciente
                FROM App\Entity\Factura factura
                JOIN App\Entity\User userCajero
                WITH factura.cajeroId = userCajero.id
                JOIN App\Entity\Cita cita
                WITH factura.citaId = cita.id
                JOIN App\Entity\TipoCita tipoCita
                WITH cita.tipoCitaId = tipoCita.id
                JOIN App\Entity\User userPaciente
                WITH cita.pacienteId = userPaciente.id
                JOIN App\Entity\User userDoctor
                WITH cita.doctorId = userDoctor.id
                WHERE factura.cajeroId = :cajero";
    return $this->_em->createQuery($strSql)
        ->setParameter('cajero',$idUser)
        ->getResult();
    ;
}

public function getFacturasFecha($fechaInicio = null, $fechaFin = null): ?array
{

    $strSql = "SELECT factura.id,
    factura.fecha_creacion fecha_factura,
    factura.totalpagar,
    tipoCita.descripcion descripcionTipoCita,
    CONCAT(CONCAT(userCajero.nombres,' '),userCajero.apellidos) nom_cajero
                FROM App\Entity\Factura factura
                JOIN App\Entity\User userCajero
                WITH factura.cajeroId = userCajero.id
                JOIN App\Entity\Cita cita
                WITH factura.citaId = cita.id
                JOIN App\Entity\TipoCita tipoCita
                WITH cita.tipoCitaId = tipoCita.id";

    //si le llegan las fechas, filtra
    if($fechaInicio != null && $fechaFin != null){
        $fechaInicio = new \DateTime($fechaInicio->format("Y-m-d")." 00:00:00");
        $fechaFin = new \DateTime($fechaFin->format("Y-m-d")." 23:59:59");

        $strCondicion = " AND factura.fecha_creacion BETWEEN :fechaInicio AND :fechaFin ";

        $strSql .= $strCondicion;
    }

    $query = $this->_em->createQuery($strSql);

    //si le llegan las fechas, setea parametros para filtrar
    if($fechaInicio != null && $fechaFin != null){
        $query->setParameter('fechaInicio',$fechaInicio)
            ->setParameter('fechaFin',$fechaFin);
    }

    return $query->getResult();
}
}
