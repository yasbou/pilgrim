<?php

namespace AppBundle\Entity\Blog;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use AppBundle\Entity\Blog\Post;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * Categories
 *
 * @ORM\Table(name="categories")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CategoriesRepository")
 */
class Categories
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
     * @ORM\Column(name="categorie_nom", type="string", length=255)
     */
    private $categorieNom;

    /**
    * @ORM\OneToMany(targetEntity="Post", mappedBy="categories")
    */
    private $posts;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }


    public function __construct()
   {
       $this->isActive = true;
        $this->posts = new ArrayCollection();

       // may not be needed, see section on salt below
       // $this->salt = md5(uniqid('', true));
   }

    /**
     * Set categorieNom
     *
     * @param string $categorieNom
     *
     * @return Categories
     */
    public function setCategorieNom($categorieNom)
    {
        $this->categorieNom = $categorieNom;

        return $this;
    }

    /**
     * Get categorieNom
     *
     * @return string
     */
    public function getCategorieNom()
    {
        return $this->categorieNom;
    }




    /**
     * Get the value of Posts
     *
     * @return mixed
     */
    public function getPosts()
    {
        return $this->posts;
    }

    /**
     * Set the value of Posts
     *
     * @param mixed posts
     *
     * @return self
     */
    public function setPosts($posts)
    {
        $this->posts = $posts;

        return $this;
    }

    public function __toString()
    {
    return $this->getCategorieNom();
    }

}
