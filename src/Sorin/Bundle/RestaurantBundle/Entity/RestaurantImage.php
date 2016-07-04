<?php

namespace Sorin\Bundle\RestaurantBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Exclude;
use JMS\Serializer\Annotation\MaxDepth;
use Symfony\Component\Routing\Router;

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
     * @MaxDepth(1)
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
     * @param \Sorin\Bundle\RestaurantBundle\Entity\Restaurant $restaurant
     * @return RestaurantImage
     */
    public function setRestaurant(\Sorin\Bundle\RestaurantBundle\Entity\Restaurant $restaurant = null)
    {
        $this->restaurant = $restaurant;

        return $this;
    }

    public function getFullImageUrl(Router $router)
    {
        return $router->getContext()->getScheme() . '://' .
        $router->getContext()->getHost() .
        $router->getContext()->getBaseUrl() . '/' .
        $this->getImageUrl();
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
}
