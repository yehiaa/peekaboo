<?php

namespace AppBundle;
use Doctrine\ORM\EntityManager;

/**
 * Class KidManagementDataSource
 * @package AppBundle
 */
class KidManagementDataSource
{
    private static $em ;
    /**
     * KidManagementDataSource constructor.
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        self::$em = $em;
    }


    /**
     * @param string $deliveryPersonMobile
     * @return array
     */
    public static function getKidsByDeliveryPersonMobile($deliveryPersonMobile)
    {
        if(strlen($deliveryPersonMobile) < 11) return [];

        $conn = self::$em->getConnection();
        $sql = "select distinct lower(BTRIM(kidname)) as name from arrival_order_lines where arrivalorder_id in (
                        select id from kid_management.arrival_orders where trim(deliverypersonmobile) like trim(:mobile) 
                ) order by name" ;
        $stmt = $conn->prepare($sql);
        $stmt->bindValue("mobile", '%' .$deliveryPersonMobile . '%');
        $stmt->execute();

        return $stmt->fetchAll();
    }
}