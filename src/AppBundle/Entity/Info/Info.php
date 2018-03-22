<?php

namespace AppBundle\Entity\Info;

use Doctrine\ORM\Mapping as ORM;

/**
 * Info
 *
 * @ORM\Table(name="info")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\InfoRepository")
 */
class Info
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
     * @ORM\Column(name="titre", type="string", length=255)
     */
    private $titre;

    /**
     * @var string
     *
     * @ORM\Column(name="soustitre", type="string", length=255, nullable=true)
     */
    private $soustitre;

    /**
     * @var string
     *
     * @ORM\Column(name="listeA", type="text")
     */
    private $listeA;

    /**
     * @var string
     *
     * @ORM\Column(name="listeB", type="text", nullable=true)
     */
    private $listeB;

    /**
     * @var string
     *
     * @ORM\Column(name="listeC", type="text", nullable=true)
     */
    private $listeC;

    /**
     * @var string
     *
     * @ORM\Column(name="listeD", type="text", nullable=true)
     */
    private $listeD;

    /**
     * @var string
     *
     * @ORM\Column(name="listeE", type="text", nullable=true)
     */
    private $listeE;





    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=255)
     */
    private $image;


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
     * Set titre
     *
     * @param string $titre
     *
     * @return Info
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;

        return $this;
    }

    /**
     * Get titre
     *
     * @return string
     */
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * Set soustitre
     *
     * @param string $soustitre
     *
     * @return Info
     */
    public function setSoustitre($soustitre)
    {
        $this->soustitre = $soustitre;

        return $this;
    }

    /**
     * Get soustitre
     *
     * @return string
     */
    public function getSoustitre()
    {
        return $this->soustitre;
    }


    /**
     * Set image
     *
     * @param string $image
     *
     * @return Info
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string
     */
    public function getImage()
    {
        return $this->image;
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
     * Get the value of Liste
     *
     * @return string
     */
    public function getListeA()
    {
        return $this->listeA;
    }

    /**
     * Set the value of Liste
     *
     * @param string listeA
     *
     * @return self
     */
    public function setListeA($listeA)
    {
        $this->listeA = $listeA;

        return $this;
    }

    /**
     * Get the value of Liste
     *
     * @return string
     */
    public function getListeB()
    {
        return $this->listeB;
    }

    /**
     * Set the value of Liste
     *
     * @param string listeB
     *
     * @return self
     */
    public function setListeB($listeB)
    {
        $this->listeB = $listeB;

        return $this;
    }

    /**
     * Get the value of Liste
     *
     * @return string
     */
    public function getListeC()
    {
        return $this->listeC;
    }

    /**
     * Set the value of Liste
     *
     * @param string listeC
     *
     * @return self
     */
    public function setListeC($listeC)
    {
        $this->listeC = $listeC;

        return $this;
    }

    /**
     * Get the value of Liste
     *
     * @return string
     */
    public function getListeD()
    {
        return $this->listeD;
    }

    /**
     * Set the value of Liste
     *
     * @param string listeD
     *
     * @return self
     */
    public function setListeD($listeD)
    {
        $this->listeD = $listeD;

        return $this;
    }

    /**
     * Get the value of Liste
     *
     * @return string
     */
    public function getListeE()
    {
        return $this->listeE;
    }

    /**
     * Set the value of Liste
     *
     * @param string listeE
     *
     * @return self
     */
    public function setListeE($listeE)
    {
        $this->listeE = $listeE;

        return $this;
    }

}
