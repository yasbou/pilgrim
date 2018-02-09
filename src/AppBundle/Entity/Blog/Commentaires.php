<?php

namespace AppBundle\Entity\Blog;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use AppBundle\Entity\Blog\Commentaires;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Commentaires
 *
 * @ORM\Table(name="commentaires")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CommentairesRepository")
 */
class Commentaires
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
     * @ORM\Column(name="auteur_com", type="string", length=255)
     */
    private $auteurCom;

    /**
     * @var string
     *
     * @ORM\Column(name="date_com", type="string",length=255 )
     */
    private $dateCom;

    /**
     * @var string
     *
     * @ORM\Column(name="text_com", type="text")
     */
    private $textCom;

    /**
    * @ORM\ManyToOne(targetEntity="Post", inversedBy="commentaires")
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

    /**
     * Set auteurCom
     *
     * @param string $auteurCom
     *
     * @return Commentaires
     */
    public function setAuteurCom($auteurCom)
    {
        $this->auteurCom = $auteurCom;

        return $this;
    }

    /**
     * Get auteurCom
     *
     * @return string
     */
    public function getAuteurCom()
    {
        return $this->auteurCom;
    }

    /**
     * Set dateCom
     *
     * @param \DateTime $dateCom
     *
     * @return Commentaires
     */
    public function setDateCom($dateCom)
    {
        $this->dateCom = $dateCom;

        return $this;
    }

    /**
     * Get dateCom
     *
     * @return \DateTime
     */
    public function getDateCom()
    {
        return $this->dateCom;
    }

    /**
     * Set textCom
     *
     * @param string $textCom
     *
     * @return Commentaires
     */
    public function setTextCom($textCom)
    {
        $this->textCom = $textCom;

        return $this;
    }

    /**
     * Get textCom
     *
     * @return string
     */
    public function getTextCom()
    {
        return $this->textCom;
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





}
