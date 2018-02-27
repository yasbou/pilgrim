<?php

namespace AppBundle\Entity\Repertoire;

use Doctrine\ORM\Mapping as ORM;

/**
 * Ville
 *
 * @ORM\Table(name="ville")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\VilleRepository")
 */
class Ville
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
     * @ORM\Column(name="nom_ville", type="string", length=255)
     */
    private $nomVille;


    /**
     * @ORM\OneToMany(targetEntity="Hotel", mappedBy="ville")
     *
     */
     private $hotels;


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
     * Set nomVille
     *
     * @param string $nomVille
     *
     * @return Ville
     */
    public function setNomVille($nomVille)
    {
        $this->nomVille = $nomVille;

        return $this;
    }

    /**
     * Get nomVille
     *
     * @return string
     */
    public function getNomVille()
    {
        return $this->nomVille;
    }

    public function __toString()
    {
      return $this->getNomVille();
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
     * Get the value of Hotels
     *
     * @return mixed
     */
    public function getHotels()
    {
        return $this->hotels;
    }

    /**
     * Set the value of Hotels
     *
     * @param mixed hotels
     *
     * @return self
     */
    public function setHotels($hotels)
    {
        $this->hotels = $hotels;

        return $this;
    }

}
