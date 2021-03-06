<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ArrivalOrderLine
 *
 * @ORM\Table(name="arrival_order_lines")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ArrivalOrderLineRepository")
 */
class ArrivalOrderLine implements \JsonSerializable
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
     * @ORM\Column(name="kidname", type="string", length=128)
     */
    private $kidName;


    /**
     * @var string
     *
     * @ORM\Column(name="notes", type="text", nullable=true)
     */
    private $notes;


    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\ArrivalOrder", inversedBy="lines")
     */
    private $arrivalorder;


    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Item")
     */
    private $item;

    /**
     * @ORM\Column(name="allowedCategories", type="json_array", nullable=true)
     */
    private $allowedCategories;

    /**
     * @return arrivalorder
     */
    public function getArrivalorder()
    {
        return $this->arrivalorder;
    }

    /**
     * @param void
     */
    public function setArrivalorder($arrivalorder)
    {
        $this->arrivalorder = $arrivalorder;
    }


    /**
     * @return Item
     */
    public function getItem()
    {
        return $this->item;
    }

    /**
     * @param void
     */
    public function setItem($item)
    {
        $this->item = $item;
    }


    /**
     * @param void
     */
    public function setAllowedCategories($allowedCategories)
    {
        $this->allowedCategories = $allowedCategories;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }


    /**
     * Set kidName
     *
     * @param string $kidName
     *
     * @return ArrivalOrderLine
     */
    public function setKidName($kidName)
    {
        $this->kidName = $kidName;

        return $this;
    }

    /**
     * Get kidName
     *
     * @return string
     */
    public function getKidName()
    {
        return $this->kidName;
    }


    /**
     * Set notes
     *
     * @param string $notes
     *
     * @return ArrivalOrderLine
     */
    public function setNotes($notes)
    {
        $this->notes = $notes;

        return $this;
    }

    /**
     * Get notes
     *
     * @return string
     */
    public function getNotes()
    {
        return $this->notes;
    }


    public function jsonSerialize()
    {
        return array(
            'id' => $this->id,
            'kidName' => $this->kidName,
            'notes' => $this->notes,
            'item' => $this->item,
            'arrivalorderId' => $this->arrivalorderId,
        );
    }
}

