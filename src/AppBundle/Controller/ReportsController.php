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
    public function indexAction(Request $request)
    {
        $ordersRepository = $this->getDoctrine()
                                ->getManager()
                                ->getRepository(\AppBundle\Entity\ArrivalOrder::class);

        $selectedDate = $this->getSelectedDate($request->get('selectedDate'));

        $orders = $ordersRepository->findByOrderDate($selectedDate);

        return $this->render(
            '@App/reports/index.html.twig',
            ['orders' => $orders, 'selectedDate'=>$selectedDate]
            );
    }


    protected function getSelectedDate($input) : \DateTime
    {
        try {
            if ($input) {
                return new \DateTime($input);
            }
        } catch (\Exception $e) {
            
        }

        return new \DateTime();
    }
}
