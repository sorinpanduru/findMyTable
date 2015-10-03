<?php

namespace Sorin\Bundle\RestaurantBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Restaurant
 *
 * @ORM\Table(name="restaurant")
 * @ORM\Entity
 */
class Restaurant
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */

    public $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    public $name;

    /**
     * @ORM\OneToMany(targetEntity="RestaurantImage", mappedBy="restaurant", fetch="EAGER")
     */
    public $images;


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
     * @param string $name
     * @return Restaurant
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    public function __construct()
    {
        $this->images = new ArrayCollection();
    }

    /**
     * Add images
     *
     * @param \Sorin\Bundle\RestaurantBundle\Entity\RestaurantImage $images
     * @return Restaurant
     */
    public function addImage(\Sorin\Bundle\RestaurantBundle\Entity\RestaurantImage $images)
    {
        $this->images[] = $images;

        return $this;
    }

    /**
     * Remove images
     *
     * @param \Sorin\Bundle\RestaurantBundle\Entity\RestaurantImage $images
     */
    public function removeImage(\Sorin\Bundle\RestaurantBundle\Entity\RestaurantImage $images)
    {
        $this->images->removeElement($images);
    }

    /**
     * Get images
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getImages()
    {
        return $this->images;
    }
}
