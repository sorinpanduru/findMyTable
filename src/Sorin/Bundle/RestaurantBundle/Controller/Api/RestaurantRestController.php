<?php

namespace Sorin\Bundle\RestaurantBundle\Controller\Api;

use FOS\RestBundle\Request\ParamFetcher;
use FOS\RestBundle\Request\ParamReader;
use Sorin\Bundle\RestaurantBundle\Controller\MyController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations\RequestParam;
use FOS\RestBundle\View\View;
use Sorin\Bundle\RestaurantBundle\Entity;
use Sorin\Bundle\RestaurantBundle\Entity\RestaurantReservation;
use Symfony\Component\Routing\Router;

class RestaurantRestController extends MyController
{

    const RESTAURANT_NOT_FOUND = "Restaurant with id %s not found";

    /**
     * @return JsonResponse
     */
    public function getRestaurantsAction()
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

        return static::returnSerializedResponse($restaurants);
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function getRestaurantAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $restaurantRepository = $em->getRepository('Sorin\Bundle\RestaurantBundle\Entity\Restaurant');
        /** @var Entity\Restaurant $restaurant */
        $restaurant = $restaurantRepository->find($id);

        if(!$restaurant){
            return static::throwError(
                sprintf(self::RESTAURANT_NOT_FOUND, $id),
                JsonResponse::HTTP_NOT_FOUND
            );
        }

        foreach($restaurant->getImages() as &$restaurant_image)
        {
            /** @var Router $router */
            $router = $this->container->get('router');
            $restaurant_image->setImageUrl($restaurant_image->getFullImageUrl($router));
        }

        return static::returnSerializedResponse($restaurant);
    }

    /**
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function putRestaurantReservationAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $restaurantRepository = $em->getRepository('Sorin\Bundle\RestaurantBundle\Entity\Restaurant');
        /** @var Entity\Restaurant $restaurant */
        $restaurant = $restaurantRepository->find($id);

        if(!$restaurant){
            return static::throwError(
                sprintf(RestaurantRestController::RESTAURANT_NOT_FOUND, $id),
                JsonResponse::HTTP_NOT_FOUND
            );
        }

        $startTime = $request->get('start_time');
        $people = $request->get('people');

        $restaurantReservation = new RestaurantReservation();
        $restaurantReservation->setStartTime($startTime);
        $restaurantReservation->setPeople($people);
        $restaurantReservation->setRestaurant($restaurant);

        $em->persist($restaurantReservation);
        $em->flush();

        return static::returnSerializedResponse($restaurantReservation, JsonResponse::HTTP_OK);
    }
}
