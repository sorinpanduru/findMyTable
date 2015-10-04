<?php

namespace Sorin\Bundle\RestaurantBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Exclude;
use JMS\Serializer\Annotation\MaxDepth;

/**
 * @ORM\Entity
 * @ORM\Table(name="restaurant_timetable")
 */
class RestaurantTimetable
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(name="day_of_week", type="integer")
     */
    protected $dayOfWeek;

    /**
     * @ORM\Column(name="start_hour", type="string", length=2)
     */
    protected $startHour;

    /**
     * @ORM\Column(name="end_hour", type="string", length=2)
     */
    protected $endHour;

    /**
     * @ORM\ManyToOne(targetEntity="Restaurant", inversedBy="timetable", fetch="LAZY")
     * @ORM\JoinColumn(name="restaurant_id", referencedColumnName="id")
     * @MaxDepth(1)
     */
    protected $restaurant;


    /**
     * Set restaurant
     *
     * @param \Sorin\Bundle\RestaurantBundle\Entity\Restaurant $restaurant
     * @return RestaurantTimetable
     */
    public function setRestaurant(\Sorin\Bundle\RestaurantBundle\Entity\Restaurant $restaurant = null)
    {
        $this->restaurant = $restaurant;

        return $this;
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

    private function __serialize()
    {
        return "";
    }
}
