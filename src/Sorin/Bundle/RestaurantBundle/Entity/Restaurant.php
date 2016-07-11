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

    const RESTAURANT_NOT_FOUND = "Restaurant with id %s not found";
    
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */

    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    protected $name;

    /**
     *
     * @ORM\OneToMany(targetEntity="RestaurantTimetable", mappedBy="restaurant", fetch="LAZY")
     */
    protected $timetable;

    /**
     * @ORM\OneToMany(targetEntity="RestaurantImage", mappedBy="restaurant", fetch="EAGER")
     */
    protected $images;

    public function __construct()
    {
        $this->images = new ArrayCollection();
    }

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
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
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
