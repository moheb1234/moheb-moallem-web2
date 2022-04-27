<?php

namespace App\Controller\model;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Table;

/**
 * @ORM\Entity
 * @Table(schema="symfony" ,name="attraction")
 */
class Attraction
{
    /**
     *@ORM\Id()
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;
    /**
     * @ORM\Column(type="string")
     */
    private $name;
    /**
     * @ORM\Column(type="string")
     */
    private $shortDescription;
    /**
     * @ORM\Column(type="string")
     */
    private $fullDescription;
    /**
     * @ORM\Column(type="integer")
     */
    private $score;
    /**
     * @ORM\Column(type="string")
     */
    private $createdAt;
    /**
     * @ORM\Column(type="string")
     */
    private $updatedAt;

    /**
     * @param $id
     * @param $name
     * @param $shortDescription
     * @param $fullDescription
     * @param $score
     * @param $createdAt
     * @param $updatedAt
     */
    public function __construct($id, $name, $shortDescription, $fullDescription, $score, $createdAt, $updatedAt)
    {
        $this->id = $id;
        $this->name = $name;
        $this->shortDescription = $shortDescription;
        $this->fullDescription = $fullDescription;
        $this->score = $score;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }



}