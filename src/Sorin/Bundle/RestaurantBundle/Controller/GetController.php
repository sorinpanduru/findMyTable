<?php

namespace Sorin\Bundle\RestaurantBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

use Sorin\Bundle\RestaurantBundle\Entity;

class GetController extends Controller
{
    /**
     * @Route("/getRestaurants")
     * @Template()
     */
    public function getRestaurantsAction()
    {
        $em = $this->getDoctrine()->getManager();
        $restaurantRepository = $em->getRepository('Sorin\Bundle\RestaurantBundle\Entity\Restaurant');
        $restaurant = $restaurantRepository->find(1);

        return new JsonResponse($restaurant);
    }

}
