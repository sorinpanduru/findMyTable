<?php

namespace Sorin\Bundle\RestaurantBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

class RestaurantUser extends User
{
    public function __construct()
    {
        $this->setUserType(parent::USER_TYPE_RESTAURANT_USER);
    }
}