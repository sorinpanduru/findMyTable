<?php

namespace Sorin\Bundle\RestaurantBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;

use JMS\Serializer\SerializationContext;

use Sorin\Bundle\RestaurantBundle\Entity;

class GetController extends Controller
{
    /**
     * @Route("/getRestaurantList", name="getRestaurantList")
     * @return Response
     */
    public function getRestaurantListAction()
    {
        $em = $this->getDoctrine()->getManager();
        $restaurantRepository = $em->getRepository('Sorin\Bundle\RestaurantBundle\Entity\Restaurant');
        $restaurant = $restaurantRepository->findAll();

        return $this->serializeResponse($restaurant);
    }

    /**
     * @Route("/getRestaurantDetails/{id}", name="getRestaurantDetails")
     * @param int $id
     * @return Response
     */
    public function getRestaurantAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $restaurantRepository = $em->getRepository('Sorin\Bundle\RestaurantBundle\Entity\Restaurant');
        $restaurant = $restaurantRepository->find($id);

        return $this->serializeResponse($restaurant);
    }

    /**
     * @param mixed $entity
     * @return Response
     */
    private function serializeResponse($entity)
    {
        $serializer = $this->container->get('jms_serializer');
        $jsonContent = $serializer
            ->serialize(
                $entity,
                'json',
                SerializationContext::create()
                    ->enableMaxDepthChecks()
            );

        return new Response($jsonContent);
    }
}
