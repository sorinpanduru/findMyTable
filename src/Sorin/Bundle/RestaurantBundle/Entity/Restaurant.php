<?php

namespace Sorin\Bundle\RestaurantBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Exclude;
use JMS\Serializer\Annotation\MaxDepth;

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

    /**
     * @ORM\OneToOne(targetEntity="User", fetch="EAGER")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * @MaxDepth(1)
     */
    protected $user;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     */
    protected $address1;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     */
    protected $address2;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     */
    protected $zipCode;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     */
    protected $city;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     */
    protected $country;

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
    public function addImage(RestaurantImage $images)
    {
        $this->images[] = $images;

        return $this;
    }

    /**
     * Remove images
     *
     * @param \Sorin\Bundle\RestaurantBundle\Entity\RestaurantImage $images
     */
    public function removeImage(RestaurantImage $images)
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

    public function getUser()
    {
        return $this->user;
    }

    public function setUser(RestaurantUser $user)
    {
        $this->user = $user;
        return $this;
    }
}
