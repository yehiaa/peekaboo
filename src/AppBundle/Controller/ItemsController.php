<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ItemsController extends Controller
{
    /**
     * @Route("/items")
     */
    public function indexAction()
    {
        $itemsRepository = $this->getDoctrine()
                                ->getManager()
                                ->getRepository(\AppBundle\Entity\Item::class);

        $items = $itemsRepository->findAll();
        return $this->json(['items'=> $items]);
    }
}
