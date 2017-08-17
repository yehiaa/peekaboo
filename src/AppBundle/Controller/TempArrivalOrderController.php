<?php

namespace AppBundle\Controller;

use AppBundle\Entity\ArrivalOrderLine;
use AppBundle\KidManagementDataSource;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\ArrivalOrder;

use Symfony\Component\HttpFoundation\Request;

class TempArrivalOrderController extends Controller
{

    /**
     * @Route("/")
     */
    public function indexAction()
    {
        return $this->render('@App/TempArrivalOrder/index.html.twig');
    }
    /**
     * @Route("/create")
     */
    public function createAction()
    {
        return $this->render('@App/TempArrivalOrder/create.html.twig');
    }


    /**
     * @Route("/save", methods={ Request::METHOD_POST })
     */
    public function saveAction(Request $request)
    {
        $em = $this->getDoctrine()
            ->getManager();
//        todo validate request
        $data = json_decode($request->getContent(), true);
        $deliveryPerson = $data['deliveryPerson'];
        $kids = $data['kids'];
        $arrivalOrder = new ArrivalOrder();
        $arrivalOrder->setDeliveryPerson($deliveryPerson['name']);
        $arrivalOrder->setDeliveryPersonMobile($deliveryPerson['mobile']);
        $arrivalOrder->setOrderDate(new \DateTime());

        foreach ($kids as $kid){
            $line = new ArrivalOrderLine();
            $line->setKidName($kid['name']);
            $line->setNotes(isset($kid['notes']) ? $kid['notes'] : "");
            $line->setArrivalorder($arrivalOrder);
            $em->persist($line);
        }

        $em->persist($arrivalOrder);
        $em->flush();

        return $this->json($arrivalOrder);
    }


    /**
     * @Route("/kids/{mobile}")
     */
    public function kidsByMobileAction($mobile)
    {
//        todo create a service ..
        $kidsDataStore = new KidManagementDataSource( $this->getDoctrine()->getManager() );
        $kids = $kidsDataStore::getKidsByDeliveryPersonMobile($mobile);
        return $this->json($kids);
    }
}
