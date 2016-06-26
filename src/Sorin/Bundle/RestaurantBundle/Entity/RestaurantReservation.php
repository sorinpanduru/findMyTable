<?php

namespace Sorin\Bundle\RestaurantBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Exclude;
use JMS\Serializer\Annotation\MaxDepth;
use Symfony\Component\Routing\Router;
use Symfony\Component\Validator\Constraints\DateTime;

/**
 * @ORM\Entity
 * @ORM\Table(name="restaurant_reservation")
 */
class RestaurantReservation
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    public $id;

    /**
     * @ORM\ManyToOne(targetEntity="Restaurant", inversedBy="images", fetch="EAGER")
     * @ORM\JoinColumn(name="restaurant_id", referencedColumnName="id")
     * @MaxDepth(1)
     */
    public $restaurant;

    /**
     * @ORM\Column(type="string", length=100)
     */
    public $start_time;

    /**
     * @ORM\Column(type="integer", length=100)
     */
    public $people;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set restaurant
     *
     * @param \Sorin\Bundle\RestaurantBundle\Entity\Restaurant $restaurant
     * @return RestaurantImage
     */
    public function setRestaurant(\Sorin\Bundle\RestaurantBundle\Entity\Restaurant $restaurant = null)
    {
        $this->restaurant = $restaurant;

        return $this;
    }

    public function setStartTime($start_time)
    {
        $startTime = new \DateTime($start_time);
        if(!$startTime)
        {
            throw new \RuntimeException(sprintf("Invalid Date Format: %s", $start_time));
        }
        $this->start_time = $startTime->format('Y-m-d');
    }

    public function setPeople($people)
    {
        $this->people = $people;
    }

    /**
     * Get restaurant
     *
     * @return \Sorin\Bundle\RestaurantBundle\Entity\Restaurant
     */
    public function getRestaurant()
    {
        return $this->restaurant;
    }
}
