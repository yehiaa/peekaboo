<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ArrivalOrderLine
 *
 * @ORM\Table(name="temp_arrival.arrival_order_lines")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ArrivalOrderLineRepository")
 */
class ArrivalOrderLine
{
    /**
     * @var guid
     *
     * @ORM\Column(name="id", type="guid")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="UUID")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="kidcode", type="string", length=16, nullable=true)
     */
    private $kidCode;

    /**
     * @var string
     *
     * @ORM\Column(name="locker", type="string", length=32, nullable=true)
     */
    private $locker;

    /**
     * @var string
     *
     * @ORM\Column(name="kidname", type="string", length=128, nullable=true)
     */
    private $kidName;

    /**
     * @var bool
     *
     * @ORM\Column(name="withnanny", type="boolean", nullable=true)
     */
    private $withNanny;

    /**
     * @var string
     *
     * @ORM\Column(name="nannyname", type="string", length=128, nullable=true)
     */
    private $nannyName;

    /**
     * @var string
     *
     * @ORM\Column(name="notes", type="text", nullable=true)
     */
    private $notes;

    /**
     * @var guid
     *
     * @ORM\Column(name="arrivalorder_id", type="guid")
     */
    private $arrivalOrderId;


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
     * Set kidCode
     *
     * @param string $kidCode
     *
     * @return ArrivalOrderLine
     */
    public function setKidCode($kidCode)
    {
        $this->kidCode = $kidCode;

        return $this;
    }

    /**
     * Get kidCode
     *
     * @return string
     */
    public function getKidCode()
    {
        return $this->kidCode;
    }

    /**
     * Set locker
     *
     * @param string $locker
     *
     * @return ArrivalOrderLine
     */
    public function setLocker($locker)
    {
        $this->locker = $locker;

        return $this;
    }

    /**
     * Get locker
     *
     * @return string
     */
    public function getLocker()
    {
        return $this->locker;
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
     * Set withNanny
     *
     * @param boolean $withNanny
     *
     * @return ArrivalOrderLine
     */
    public function setWithNanny($withNanny)
    {
        $this->withNanny = $withNanny;

        return $this;
    }

    /**
     * Get withNanny
     *
     * @return bool
     */
    public function getWithNanny()
    {
        return $this->withNanny;
    }

    /**
     * Set nannyname
     *
     * @param string $nannyName
     *
     * @return ArrivalOrderLine
     */
    public function setNannyName($nannyName)
    {
        $this->nannyName = $nannyName;

        return $this;
    }

    /**
     * Get nannyname
     *
     * @return string
     */
    public function getNannyName()
    {
        return $this->nannyName;
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

    /**
     * Set arrivalorderId
     *
     * @param guid $arrivalOrderId
     *
     * @return ArrivalOrderLine
     */
    public function setArrivalOrderId($arrivalOrderId)
    {
        $this->arrivalOrderId = $arrivalOrderId;

        return $this;
    }

    /**
     * Get arrivalorderId
     *
     * @return guid
     */
    public function getArrivalOrderId()
    {
        return $this->arrivalorderId;
    }
}

