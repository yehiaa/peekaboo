<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Item
 *
 * @ORM\Table(name="items")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ItemRepository")
 */
class Item implements \JsonSerializable
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="NAME", type="string")
     */
    private $name;


    /**
     * @var integer
     *
     * @ORM\Column(name="price", type="integer", nullable=true)
     */
    private $price;


    public function __construct()
    {
    }

    /**
     * Get id
     *
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }


    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }


    /**
     * Get price
     *
     * @return integer
     */
    public function getPrice()
    {
        return $this->price;
    }


    public function jsonSerialize()
    {
        return array(
            'id' => $this->id,
            'name'=> $this->name,
            'price'=> $this->price,
        );
    }
}

