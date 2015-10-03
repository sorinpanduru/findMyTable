<?php

namespace Sorin\Bundle\RestaurantBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class GetControllerTest extends WebTestCase
{
    public function testGetrestaurants()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/getRestaurants');
    }

}
