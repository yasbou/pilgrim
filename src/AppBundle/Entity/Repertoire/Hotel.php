<?php

namespace AppBundle\Entity\Repertoire;

use Doctrine\ORM\Mapping as ORM;

/**
 * Hotel
 *
 * @ORM\Table(name="hotel")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\HotelRepository")
 */
class Hotel
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
     * @ORM\Column(name="nom", type="string", length=255)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="adresse", type="string", length=255)
     */
    private $adresse;

    /**
    * @ORM\ManyToOne(targetEntity="Ville", inversedBy="hotels")
    *
    */
    private $ville;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre_etoile", type="string", length=255)
     */
    private $nombreEtoile;

    /**
     * @var string
     *
     * @ORM\Column(name="proximite", type="text")
     */
    private $proximite;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @ORM\OneToMany(targetEntity="CommentaireHotel", mappedBy="hotel")
     *
     */
     private $commentaires;


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
     * Set nom
     *
     * @param string $nom
     *
     * @return Hotel
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set adresse
     *
     * @param string $adresse
     *
     * @return Hotel
     */
    public function setAdresse($adresse)
    {
        $this->adresse = $adresse;

        return $this;
    }

    /**
     * Get adresse
     *
     * @return string
     */
    public function getAdresse()
    {
        return $this->adresse;
    }

    /**
     * Set ville
     *
     * @param string $ville
     *
     * @return Hotel
     */
    public function setVille($ville)
    {
        $this->ville = $ville;

        return $this;
    }

    /**
     * Get ville
     *
     * @return string
     */
    public function getVille()
    {
        return $this->ville;
    }

    /**
     * Set nombreEtoile
     *
     * @param string $nombreEtoile
     *
     * @return Hotel
     */
    public function setNombreEtoile($nombreEtoile)
    {
        $this->nombreEtoile = $nombreEtoile;

        return $this;
    }

    /**
     * Get nombreEtoile
     *
     * @return string
     */
    public function getNombreEtoile()
    {
        return $this->nombreEtoile;
    }

    /**
     * Set proximite
     *
     * @param string $proximite
     *
     * @return Hotel
     */
    public function setProximite($proximite)
    {
        $this->proximite = $proximite;

        return $this;
    }

    /**
     * Get proximite
     *
     * @return string
     */
    public function getProximite()
    {
        return $this->proximite;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Hotel
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
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
     * Get the value of Commentaires
     *
     * @return mixed
     */
    public function getCommentaires()
    {
        return $this->commentaires;
    }

    /**
     * Set the value of Commentaires
     *
     * @param mixed commentaires
     *
     * @return self
     */
    public function setCommentaires($commentaires)
    {
        $this->commentaires = $commentaires;

        return $this;
    }

}
