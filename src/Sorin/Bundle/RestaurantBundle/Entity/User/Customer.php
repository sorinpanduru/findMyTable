<?php

namespace Sorin\Bundle\RestaurantBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

class CustomerUser extends User
{
    public function __construct()
    {
        $this->setUserType(parent::USER_TYPE_RESTAURANT_USER);
    }
}