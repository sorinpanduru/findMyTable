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
    const RESERVATION_STATUS_REJECTED = 30;

    const RESTAURANT_RESERVATION_NOT_FOUND = "Reservation %s not found.";
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Restaurant", inversedBy="images", fetch="EAGER")
     * @ORM\JoinColumn(name="restaurant_id", referencedColumnName="id")
     * @MaxDepth(1)
     */
    protected $restaurant;

    /**
     * @ORM\Column(type="datetime", length=100)
     */
    protected $startTime;

    /**
     * @ORM\Column(type="integer")
     */
    protected $people;

    /**
     * @ORM\Column(type="integer")
     */
    protected $statusId;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $cancelReason;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $cancelAt;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $confirmDetails;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $confirmAt;

    /**
     * @ORM\ManyToOne(targetEntity="User", fetch="EAGER")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * @MaxDepth(1)
     */
    protected $user;

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
     * @param string $start_time
     * @return $this
     */
    public function setStartTime(string $start_time)
    {
        $startTime = new \DateTime($start_time, new \DateTimeZone("UTC"));
        if (!$startTime) {
            throw new \RuntimeException(sprintf("Invalid Date Format: %s", $start_time));
        }
        $this->startTime = $startTime;
        return $this;
    }

    /**
     * @param int $people
     * @return $this
     */
    public function setPeople(int $people)
    {
        $this->people = $people;
        return $this;
    }

    /**
     * @param string $cancelReason
     * @return $this
     */
    public function setCancelReason(string $cancelReason)
    {
        $this->cancelReason = $cancelReason;
        return $this;
    }

    /**
     * @param \DateTime $cancelAt
     * @return $this
     */
    public function setCancelAt(\DateTime $cancelAt)
    {
        $this->cancelAt = $cancelAt;
        return $this;
    }

    /**
     * @param string $confirmDetails
     * @return $this
     */
    public function setConfirmDetails(string $confirmDetails)
    {
        $this->confirmDetails = $confirmDetails;
        return $this;
    }

    /**
     * @param \DateTime $confirmAt
     * @return $this
     */
    public function setConfirmAt(\DateTime $confirmAt)
    {
        $this->confirmAt = $confirmAt;
        return $this;
    }

    /**
     * @param int $statusId
     * @return $this
     */
    public function setStatusId(int $statusId)
    {
        if ($statusId == self::RESERVATION_STATUS_NEW ||
            $statusId == self::RESERVATION_STATUS_CANCELED ||
            $statusId == self::RESERVATION_STATUS_CONFIRMED ||
            $statusId == self::RESERVATION_STATUS_REJECTED
        ) {
            $this->statusId = $statusId;
        } else {
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

    public function getUser()
    {
        return $this->user;
    }

    public function setUser(User $user)
    {
        $this->user = $user;
        return $this;
    }
}
