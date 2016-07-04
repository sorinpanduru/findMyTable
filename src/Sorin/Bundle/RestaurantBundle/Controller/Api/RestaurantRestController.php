<?php

namespace Sorin\Bundle\RestaurantBundle\Controller\Api;

use Doctrine\ORM\EntityRepository;
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
    /**
     * @return JsonResponse
     */
    public function getRestaurantsAction()
    {
        $em = $this->getDoctrine()->getManager();
        /** @var EntityRepository $restaurantRepository */
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
        /** @var EntityRepository $restaurantRepository */
        $restaurantRepository = $em->getRepository('Sorin\Bundle\RestaurantBundle\Entity\Restaurant');
        /** @var Entity\Restaurant $restaurant */
        $restaurant = $restaurantRepository->find($id);

        if(!$restaurant){
            return static::throwError(
                sprintf(Entity\Restaurant::RESTAURANT_NOT_FOUND, $id),
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
        /** @var EntityRepository $restaurantRepository */
        $restaurantRepository = $em->getRepository('Sorin\Bundle\RestaurantBundle\Entity\Restaurant');
        /** @var Entity\Restaurant $restaurant */
        $restaurant = $restaurantRepository->find($id);

        if(!$restaurant){
            return static::throwError(
                sprintf(Entity\Restaurant::RESTAURANT_NOT_FOUND, $id),
                JsonResponse::HTTP_NOT_FOUND
            );
        }

        $startTime = $request->get('start_time');
        $people = $request->get('people');

        $restaurantReservation = new RestaurantReservation();
        $restaurantReservation->setStartTime($startTime)
            ->setPeople($people)
            ->setRestaurant($restaurant)
            ->setStatusId(RestaurantReservation::RESERVATION_STATUS_NEW);

        $em->persist($restaurantReservation);
        $em->flush();

        return static::returnSerializedResponse($restaurantReservation);
    }

    /**
     * @param Request $request
     * @param int $reservationId
     * @return JsonResponse
     */
    public function postCancelRestaurantReservationAction(Request $request, $reservationId)
    {
        $em = $this->getDoctrine()->getManager();
        /** @var EntityRepository $reservationRepository */
        $reservationRepository = $em->getRepository('Sorin\Bundle\RestaurantBundle\Entity\RestaurantReservation');
        /** @var Entity\RestaurantReservation $restaurant */
        $restaurantReservation = $reservationRepository->find($reservationId);

        if (!$restaurant) {
            return static::throwError(
                sprintf(Entity\RestaurantReservation::RESTAURANT_RESERVATION_NOT_FOUND, $reservationId),
                JsonResponse::HTTP_NOT_FOUND
            );
        }

        $cancelReason = $request->get('reason');

        $restaurantReservation->setCancelAt(new \DateTime())
            ->setCancelReason($cancelReason)
            ->setStatusId(RestaurantReservation::RESERVATION_STATUS_CANCELED);

        $em->persist($restaurantReservation);
        $em->flush();

        return static::returnSerializedResponse($restaurantReservation);
    }

    /**
     * @param Request $request
     * @param int $reservationId
     * @return JsonResponse
     */
    public function postConfirmRestaurantReservationAction(Request $request, $reservationId)
    {
        $em = $this->getDoctrine()->getManager();
        /** @var EntityRepository $reservationRepository */
        $reservationRepository = $em->getRepository('Sorin\Bundle\RestaurantBundle\Entity\RestaurantReservation');
        /** @var Entity\RestaurantReservation $restaurant */
        $restaurantReservation = $reservationRepository->find($reservationId);

        if (!$restaurant) {
            return static::throwError(
                sprintf(Entity\RestaurantReservation::RESTAURANT_RESERVATION_NOT_FOUND, $reservationId),
                JsonResponse::HTTP_NOT_FOUND
            );
        }

        $confirmDetails = $request->get('reason');

        $restaurantReservation->setConfirmAt(new \DateTime())
            ->setConfirmDetails($confirmDetails)
            ->setStatusId(RestaurantReservation::RESERVATION_STATUS_CONFIRMED);

        $em->persist($restaurantReservation);
        $em->flush();

        return static::returnSerializedResponse($restaurantReservation);
    }
}
