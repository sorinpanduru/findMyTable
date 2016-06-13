<?php

namespace Sorin\Bundle\RestaurantBundle\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;

use JMS\Serializer\SerializerBuilder;

use Sorin\Bundle\RestaurantBundle\Entity;
use Symfony\Component\Routing\Router;

class ApiRestaurantController extends Controller
{
    /**
     * @Route("/getRestaurantList", name="getRestaurantList")
     * @return Response
     */
    public function getRestaurantListAction()
    {
        $em = $this->getDoctrine()->getManager();
        $restaurantRepository = $em->getRepository('Sorin\Bundle\RestaurantBundle\Entity\Restaurant');
        $restaurants = $restaurantRepository->findAll();

        /** @var Entity\Restaurant $restaurant */
        foreach($restaurants as &$restaurant)
        {
            /** @var Entity\RestaurantImage $restaurant_image */
            foreach($restaurant->getImages() as &$restaurant_image)
            {
                /** @var Router $router */
                $router = $this->container->get('router');
                $restaurant_image->setImageUrl($restaurant_image->getFullImageUrl($router));
            }
        }

        return $this->serializeResponse($restaurants);
    }

    /**
     * @param mixed $entity
     * @return Response
     */
    private function serializeResponse($entity)
    {
        $serializer = SerializerBuilder::create()->build();
        $jsonContent = $serializer->serialize($entity, 'json');
        return new Response($jsonContent, 200);
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
        /** @var Entity\Restaurant $restaurant */
        $restaurant = $restaurantRepository->find($id);

        foreach($restaurant->getImages() as &$restaurant_image)
        {
            /** @var Router $router */
            $router = $this->container->get('router');
            $restaurant_image->setImageUrl($restaurant_image->getFullImageUrl($router));
        }

        return $this->serializeResponse($restaurant);
    }
}
