<?php

namespace AppBundle\Controller;

use AppBundle\Entity\ArrivalOrderLine;
use AppBundle\KidManagementDataSource;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\ArrivalOrder;

use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Validator\Constraints as Assert;

use Symfony\Component\HttpFoundation\Response;

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
        $productCategoriesRepository = $this->getDoctrine()
                                            ->getManager()
                                            ->getRepository(
                                                \AppBundle\Entity\ProductCategory::class
                                            );

        $productCategories = $productCategoriesRepository->findBy([
                                                            'parent' => null,
                                                            'special' => false
                                                            ]);
        return $this->render(
            '@App/TempArrivalOrder/create.html.twig',
            ['productCategories' => $productCategories]
            );
    }


    /**
     * @Route("/save", methods={ Request::METHOD_POST })
     */
    public function saveAction(Request $request)
    {
        $data = json_decode($request->getContent(), true);

        $errors = $this->validateData($data);
        
        if(count($errors) > 0)
            // return new Response($errors, 403);
            return $this->json($errors, 403);

        $em = $this->getDoctrine()
                    ->getManager();

        $deliveryPerson = $data['deliveryPerson'];
        $kids = $data['kids'];
        $arrivalOrder = new ArrivalOrder();
        $arrivalOrder->setDeliveryPerson($deliveryPerson['name']);
        $arrivalOrder->setDeliveryPersonMobile($deliveryPerson['mobile']);
        $arrivalOrder->setOrderDate(new \DateTime());

        foreach ($kids as $kid){
            $line = new ArrivalOrderLine();
            $line->setKidName($kid['name']);
            $line->setItem($kid['item']);
            $line->setNotes(isset($kid['notes']) ? $kid['notes'] : "");
            $line->setAllowedCategories(isset($kid['allowedCategoriesIds']) ? $kid['allowedCategoriesIds'] : []);
            $line->setArrivalorder($arrivalOrder);
            $em->persist($line);
        }

        $em->persist($arrivalOrder);
        $em->flush();

        return $this->json($arrivalOrder);
    }

    
    protected function validateData($data)
    {
        $errors = [];
        if (!isset($data['deliveryPerson']) || ! isset($data['kids']) ) {
            return $errors [] = 'invalid data given, delivery person or kids not provided' ;
        }

        $deliveryPersonViolations = $this->validateDeliveryPerson($data['deliveryPerson']);
        foreach ($deliveryPersonViolations as $constraintViolation) {
            $errors [] = $constraintViolation->getMessage();
        }
        
        foreach ($data['kids'] as $kid) {
            foreach($this->validateKids($kid) as $violation)
            {
                $errors [] = $violation->getMessage();
            }
        }

        return $errors;

    }    


    protected function validateDeliveryPerson($deliveryPersonData)
    {
        $validator = $this->get('validator');
        $constraint = new Assert\Collection(array(
              'name' => new Assert\Length(array('min' => 5)),
              'mobile' => new Assert\Length(array('min' => 11)),
        ));

        return $validator->validate($deliveryPersonData, $constraint);
    }


    protected function validateKids($kidsData)
    {
        $validator = $this->get('validator');
        $constraint = new Assert\Collection(array(
            'name' => new Assert\Length(array('min' => 5)),
            'notes' => new Assert\Length(array('min' => 0)),
            'item' => new Assert\Range(array('min' => 1, 'max' => 4)),
            'allowedCategoriesIds' => new Assert\Type(['type'=>'array'])
        ));

        return $validator->validate($kidsData, $constraint);
    }


    /**
     * @Route("/kids/{mobile}")
     */
    public function kidsByMobileAction($mobile)
    {
        // todo create a service ..
        $kidsDataStore = new KidManagementDataSource( $this->getDoctrine()->getManager() );
        $kids = $kidsDataStore::getKidsByDeliveryPersonMobile($mobile);
        return $this->json($kids);
    }
}
