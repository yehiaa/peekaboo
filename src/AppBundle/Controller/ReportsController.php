<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ReportsController extends Controller
{
    /**
     * @Route("/reports")
     */
    public function indexAction()
    {
        $ordersRepository = $this->getDoctrine()
                                ->getManager()
                                ->getRepository(\AppBundle\Entity\ArrivalOrder::class);

        $orders = $ordersRepository->findAll();
        return $this->render(
            '@App/reports/index.html.twig',
            ['orders' => $orders]
            );
    }
}
