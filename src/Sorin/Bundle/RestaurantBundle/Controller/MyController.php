<?php
/**
 * Created by PhpStorm.
 * User: sorin
 * Date: 21.06.2016
 * Time: 16:28
 */

namespace Sorin\Bundle\RestaurantBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use JMS\Serializer\SerializerBuilder;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Doctrine\ORM\EntityRepository;
use Sorin\Bundle\RestaurantBundle\Entity;
use Sorin\Bundle\RestaurantBundle\Entity\RestaurantReservation;

class MyController extends FOSRestController
{
    /**
     * @param mixed $entity
     * @param integer $httpCode
     * @return JsonResponse
     */
    public static function returnSerializedResponse($entity, $httpCode = Response::HTTP_OK)
    {
        $serializer = SerializerBuilder::create()->build();
        $jsonContent = $serializer->serialize($entity, 'json');
        return new JsonResponse($jsonContent, $httpCode);
    }
    
    public static function throwError($message, $httpCode = JsonResponse::HTTP_INTERNAL_SERVER_ERROR)
    {
        $response = array(
            'ok' => false,
            'message' => $message,
        );
        return new JsonResponse($response, $httpCode);
    }

    /**
     * @param Entity\RestaurantReservation $restaurantReservation
     * @return JsonResponse
     */
    public function checkCustomerAccess(RestaurantReservation $restaurantReservation)
    {
        /** @var Entity\User $user */
        $user = $this->get('security.token_storage')->getToken()->getUser();
        /** @var Entity\User $reservationUser */
        $reservationUser = $restaurantReservation->getUser();

        if (
            !$restaurantReservation ||
            $reservationUser->getId() != $user->getId()
        ) {
            return static::throwError(
                sprintf(Entity\RestaurantReservation::RESTAURANT_RESERVATION_NOT_FOUND, $restaurantReservation->getId()),
                JsonResponse::HTTP_NOT_FOUND
            );
        }
    }

    /**
     * @param Entity\RestaurantReservation $restaurantReservation
     * @return JsonResponse
     */
    public function checkRestaurantAccess(RestaurantReservation $restaurantReservation)
    {
        /** @var Entity\User $user */
        $user = $this->get('security.token_storage')->getToken()->getUser();
        /** @var Entity\Restaurant $reservationRestaurant */
        $reservationRestaurant = $restaurantReservation->getRestaurant();
        /** @var Entity\RestaurantUser $restaurantUser */
        $restaurantUser = $reservationRestaurant->getUser();

        if (
            !$restaurantReservation ||
            $restaurantUser->getId() != $user->getId()
        ) {
            return static::throwError(
                sprintf(Entity\RestaurantReservation::RESTAURANT_RESERVATION_NOT_FOUND, $restaurantReservation->getId()),
                JsonResponse::HTTP_NOT_FOUND
            );
        }
    }
}