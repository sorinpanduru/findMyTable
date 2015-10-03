<?php

namespace Sorin\Bundle\RestaurantBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="restaurant_image")
 */
class RestaurantImage
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    public $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    public $imageUrl;

    /**
     * @var int
     * @ORM\Column(type="integer", length=1)
     */
    public $isMainImage;

    /**
     * @ORM\ManyToOne(targetEntity="Restaurant", inversedBy="images", fetch="EAGER")
     * @ORM\JoinColumn(name="restaurant_id", referencedColumnName="id")
     */
    public $restaurant;


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
     * Set name
     *
     * @param string $imageUrl
     * @return Restaurant
     */
    public function setImageUrl($imageUrl)
    {
        $this->imageUrl = $imageUrl;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getImageUrl()
    {
        return $this->imageUrl;
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
