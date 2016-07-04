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
}