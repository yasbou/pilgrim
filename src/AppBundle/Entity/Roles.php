<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use AppBundle\Entity\User;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Roles
 *
 * @ORM\Table(name="roles")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\RolesRepository")
 */
class Roles
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="role_user", type="string", length=255)
     */
    private $roleUser;

    /**
     * @ORM\OneToMany(targetEntity="User", mappedBy="role")
     */
    private $users;


    public function __construct()
        {
            $this->users = new ArrayCollection();
        }


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set roleUser
     *
     * @param string $roleUser
     *
     * @return Roles
     */
    public function setRoleUser($roleUser)
    {
        $this->roleUser = $roleUser;

        return $this;
    }

    /**
     * Get roleUser
     *
     * @return string
     */
    public function getRoleUser()
    {
        return $this->roleUser;
    }

    public function __toString()
    {
        return $this->getRoleUser();
    }



    /**
     * Get the value of Users
     *
     * @return mixed
     */
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * Set the value of Users
     *
     * @param mixed users
     *
     * @return self
     */
    public function setUsers($users)
    {
        $this->users = $users;

        return $this;
    }

}
