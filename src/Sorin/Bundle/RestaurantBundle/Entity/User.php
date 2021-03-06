<?php

namespace Sorin\Bundle\RestaurantBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;

/**
 * Restaurant
 *
 * @ORM\Table(name="user")
 * @ORM\Entity
 */
class User implements UserInterface, \Serializable, AdvancedUserInterface
{

    const USER_TYPE_CUSTOMER = 1;
    const USER_TYPE_RESTAURANT_USER = 2;

    const USER_STATUS_INACTIVE = 0;
    const USER_STATUS_ACTIVE = 1;
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
     * @ORM\Column(name="email", type="string", length=150)
     */
    protected $email;

    /**
     * @var string
     *
     * @ORM\Column(name="first_name", type="string", length=80)
     */
    protected $firstName;

    /**
     * @var string
     *
     * @ORM\Column(name="last_name", type="string", length=80)
     */
    protected $lastName;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255)
     */
    protected $password;

    /**
     * @var integer
     *
     * @ORM\Column(name="user_type", type="integer", length=1)
     */
    protected $userType;

    /**
     * @var string
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    protected $createdAt;

    /**
     * @var string
     *
     * @ORM\Column(name="modified_at", type="datetime", nullable=true)
     */
    protected $modifiedAt;

    /**
     * @var integer
     * @ORM\Column(name="is_active", type="integer", nullable=true)
     */
    protected $isActive;

    public function getId()
    {
        return $this->id;
    }

    public function getFullName()
    {
        return $this->firstName . " " . $this->lastName;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getIsActive()
    {
        return $this->isActive;
    }

    public function setEmail(string $email)
    {
        $this->email = $email;
        return $this;
    }

    public function setFirstName(string $firstName)
    {
        $this->firstName = $firstName;
        return $this;
    }

    public function setLastName(string $lastName)
    {
        $this->lastName = $lastName;
        return $this;
    }

    public function setPassword(string $password)
    {
        $this->password = $password;
        return $this;
    }

    public function setCreatedAt(\DateTime $createdAt)
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function setModifiedAt(\DateTime $modifiedAt)
    {
        $this->modifiedAt = $modifiedAt;
        return $this;
    }

    public function setUserType(int $userType)
    {
        if($userType === self::USER_TYPE_RESTAURANT_USER ||
            $userType === self::USER_TYPE_CUSTOMER
        ){
            $this->userType = $userType;
        }
        return $this;
    }

    public function setIsActive(int $isActive)
    {
        if($isActive === self::USER_STATUS_INACTIVE || $isActive === self::USER_STATUS_ACTIVE)
        {
            $this->isActive = $isActive;
        }
        return $this;
    }

    public function eraseCredentials()
    {
        $this->setPassword('');
    }

    public function getSalt()
    {
        return null;
    }

    public function getUsername()
    {
        return $this->email;
    }

    public function getPassword()
    {
        // TODO: Implement getPassword() method.
        return $this->password;
    }

    public function getRoles()
    {
        if($this->userType == self::USER_TYPE_CUSTOMER) {
            return array('ROLE_CUSTOMER');
        }elseif($this->userType == self::USER_TYPE_RESTAURANT_USER) {
            return array('ROLE_RESTAURANT_USER');
        }
    }

    public function isEnabled()
    {
        return $this->getIsActive() == 1 ? true : false;
    }

    public function isAccountNonExpired()
    {
        return $this->isEnabled();
    }

    public function isAccountNonLocked()
    {
        return $this->isEnabled();
    }

    public function isCredentialsNonExpired()
    {
        return $this->isEnabled();
    }

    /** @see \Serializable::serialize() */
    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->email,
            $this->password,
        ));
    }

    /** @see \Serializable::unserialize() */
    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->email,
            $this->password,
            ) = unserialize($serialized);
    }

}