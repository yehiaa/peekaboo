<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * ArrivalOrder
 *
 * @ORM\Table(name="arrival_orders")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ArrivalOrderRepository")
 */
class ArrivalOrder implements \JsonSerializable
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
     * @var \DateTime
     *
     * @ORM\Column(name="orderdate", type="datetime")
     */
    private $orderDate;

    /**
     * @var string
     *
     * @ORM\Column(name="deliveryperson", type="string", length=128)
     */
    private $deliveryPerson;

    /**
     * @var string
     *
     * @ORM\Column(name="deliverypersonmobile", type="string", length=512)
     */
    private $deliveryPersonMobile;

    /**
     * @var string
     *
     * @ORM\Column(name="notes", type="text", nullable=true)
     */
    private $notes;

    public function __construct()
    {
//        $this->lines = new ArrayCollection();
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
     * Set orderDate
     *
     * @param \DateTime $orderDate
     *
     * @return ArrivalOrder
     */
    public function setOrderDate($orderDate)
    {
        $this->orderDate = $orderDate;

        return $this;
    }

    /**
     * Get orderDate
     *
     * @return \DateTime
     */
    public function getOrderDate()
    {
        return $this->orderDate;
    }

    /**
     * Set deliveryPerson
     *
     * @param string $deliveryPerson
     *
     * @return ArrivalOrder
     */
    public function setDeliveryPerson($deliveryPerson)
    {
        $this->deliveryPerson = $deliveryPerson;

        return $this;
    }

    /**
     * Get deliveryPerson
     *
     * @return string
     */
    public function getDeliveryPerson()
    {
        return $this->deliveryPerson;
    }

    /**
     * Set deliveryPersonMobile
     *
     * @param string $deliveryPersonMobile
     *
     * @return ArrivalOrder
     */
    public function setDeliveryPersonMobile($deliveryPersonMobile)
    {
        $this->deliveryPersonMobile = $deliveryPersonMobile;

        return $this;
    }

    /**
     * Get deliveryPersonMobile
     *
     * @return string
     */
    public function getDeliveryPersonMobile()
    {
        return $this->deliveryPersonMobile;
    }

    /**
     * Set notes
     *
     * @param string $notes
     *
     * @return ArrivalOrder
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



    /**
     * @return ArrayCollection
     */
    public function getLines()
    {
        return $this->lines;
    }

    /**
     * @param ArrayCollection $lines
     */
    public function setLines($lines)
    {
        $this->lines = $lines;
    }


    public function jsonSerialize()
    {
        return array(
            'id' => $this->id,
            'orderDate'=> $this->orderDate->format(\DateTime::ISO8601),
            'deliveryPerson'=> $this->deliveryPerson,
            'deliveryPersonMobile'=> $this->deliveryPersonMobile,
            'notes'=> $this->notes,
        );
    }
}

