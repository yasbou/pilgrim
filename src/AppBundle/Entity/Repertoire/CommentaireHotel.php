<?php

namespace AppBundle\Entity\Repertoire;

use Doctrine\ORM\Mapping as ORM;

/**
 * CommentaireHotel
 *
 * @ORM\Table(name="commentaire_hotel")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CommentaireHotelRepository")
 */
class CommentaireHotel
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
     * @ORM\Column(name="auteur", type="string", length=255)
     */
    private $auteur;

    /**
     * @var string
     *
     * @ORM\Column(name="date", type="text")
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="commentaire", type="text")
     */
    private $commentaire;

    /**
    * @ORM\ManyToOne(targetEntity="Hotel", inversedBy="commentaires")
    *
    */
    private $hotel;


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
     * Set auteur
     *
     * @param string $auteur
     *
     * @return CommentaireHotel
     */
    public function setAuteur($auteur)
    {
        $this->auteur = $auteur;

        return $this;
    }

    /**
     * Get auteur
     *
     * @return string
     */
    public function getAuteur()
    {
        return $this->auteur;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return CommentaireHotel
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set commentaire
     *
     * @param string $commentaire
     *
     * @return CommentaireHotel
     */
    public function setCommentaire($commentaire)
    {
        $this->commentaire = $commentaire;

        return $this;
    }

    /**
     * Get commentaire
     *
     * @return string
     */
    public function getCommentaire()
    {
        return $this->commentaire;
    }

    /**
     * Set the value of Id
     *
     * @param int id
     *
     * @return self
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of Hotel
     *
     * @return mixed
     */
    public function getHotel()
    {
        return $this->hotel;
    }

    /**
     * Set the value of Hotel
     *
     * @param mixed hotel
     *
     * @return self
     */
    public function setHotel($hotel)
    {
        $this->hotel = $hotel;

        return $this;
    }


}
