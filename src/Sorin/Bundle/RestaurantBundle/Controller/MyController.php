<?php
/**
 * Created by PhpStorm.
 * User: sorin
 * Date: 21.06.2016
 * Time: 16:28
 */

namespace Sorin\Bundle\RestaurantBundle\Controller;

use JMS\Serializer\SerializerBuilder;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MyController extends Controller
{
    /**
     * @param mixed $entity
     * @param integer $httpCode
     * @return Response
     */
    public static function serializeResponse($entity, $httpCode = Response::HTTP_OK)
    {
        $serializer = SerializerBuilder::create()->build();
        $jsonContent = $serializer->serialize($entity, 'json');
        return new Response($jsonContent, $httpCode);
    }
}