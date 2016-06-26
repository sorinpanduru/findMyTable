<?php

namespace Sorin\Bundle\RestaurantBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Exclude;
use JMS\Serializer\Annotation\MaxDepth;
use JMS\Serializer\Exception\RuntimeException;
use Symfony\Component\Routing\Router;
use Symfony\Component\Validator\Constraints\DateTime;

/**
 * @ORM\Entity
 * @ORM\Table(name="restaurant_reservation")
 */
class RestaurantReservation
{
    const RESERVATION_STATUS_NEW = 10;
    const RESERVATION_STATUS_CONFIRMED = 20;
    const RESERVATION_STATUS_CANCELED = 50;

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
    public $startTime;

    /**
     * @ORM\Column(type="integer")
     */
    public $people;

    /**
     * @ORM\Column(type="integer")
     */
    public $statusId;

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
     * @param Restaurant $restaurant
     * @return RestaurantReservation
     */
    public function setRestaurant(Restaurant $restaurant = null)
    {
        $this->restaurant = $restaurant;

        return $this;
    }

    public function setStartTime($start_time)
    {
        $startTime = new \DateTime($start_time, new \DateTimeZone("UTC"));
        if(!$startTime)
        {
            throw new \RuntimeException(sprintf("Invalid Date Format: %s", $start_time));
        }
        $this->startTime = $startTime->format('Y-m-d H:i:s');
        return $this;
    }

    public function setPeople(int $people)
    {
        $this->people = $people;
        return $this;
    }

    public function setStatusId(int $statusId)
    {
        if($statusId == self::RESERVATION_STATUS_NEW ||
            $statusId == self::RESERVATION_STATUS_CANCELED ||
            $statusId == self::RESERVATION_STATUS_CONFIRMED
        ){
            $this->statusId = $statusId;
        }else{
            throw new \RuntimeException("Invalid statusId provided: " . $statusId);
        }
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
}
