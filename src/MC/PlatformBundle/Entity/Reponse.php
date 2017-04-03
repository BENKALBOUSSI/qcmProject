<?php

namespace MC\PlatformBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Reponse
 *
 * @ORM\Table(name="reponse")
 * @ORM\Entity(repositoryClass="MC\PlatformBundle\Repository\ReponseRepository")
 */
class Reponse
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
     * @ORM\Column(name="rep", type="string", length=255)
     */
    private $rep;

    /**
     * @var bool
     *
     * @ORM\Column(name="correcte", type="boolean")
     */
    private $correcte;


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
     * Set rep
     *
     * @param string $rep
     *
     * @return Reponse
     */
    public function setRep($rep)
    {
        $this->rep = $rep;

        return $this;
    }

    /**
     * Get rep
     *
     * @return string
     */
    public function getRep()
    {
        return $this->rep;
    }

    /**
     * Set correcte
     *
     * @param boolean $correcte
     *
     * @return Reponse
     */
    public function setCorrecte($correcte)
    {
        $this->correcte = $correcte;

        return $this;
    }

    /**
     * Get correcte
     *
     * @return bool
     */
    public function getCorrecte()
    {
        return $this->correcte;
    }
}

