<?php

namespace MC\PlatformBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Question
 *
 * @ORM\Table(name="question")
 * @ORM\Entity(repositoryClass="MC\PlatformBundle\Repository\QuestionRepository")
 */
class Question
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
     * @ORM\Column(name="quest", type="string", length=255)
     */
    private $quest;

    /**
     * @ORM\ManyToMany(targetEntity="MC\PlatformBundle\Entity\Reponse", cascade={"persist"})
     */
    private $reponses;

    // Constructeur
    public function __construct()
    {
        $this->reponses = new ArrayCollection();
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
     * Set quest
     *
     * @param string $quest
     *
     * @return Question
     */
    public function setQuest($quest)
    {
        $this->quest = $quest;

        return $this;
    }

    /**
     * Get quest
     *
     * @return string
     */
    public function getQuest()
    {
        return $this->quest;
    }

    /**
     * Add reponse
     *
     * @param \MC\PlatformBundle\Entity\Reponse $reponse
     *
     * @return Question
     */
    public function addReponse(Reponse $reponse)
    {
        $this->reponses[] = $reponse;

        return $this;
    }

    /**
     * Remove reponse
     *
     * @param \MC\PlatformBundle\Entity\Reponse $reponse
     */
    public function removeReponse(Reponse $reponse)
    {
        $this->reponses->removeElement($reponse);
    }

    /**
     * Get reponses
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getReponses()
    {
        return $this->reponses;
    }
}

