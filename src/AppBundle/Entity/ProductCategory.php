<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * ProductCategory
 *
 * @ORM\Table(name="inventory.product_categories")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ProductCategoryRepository")
 */
class ProductCategory implements \JsonSerializable
{
    /**
     * @var string
     *
     * @ORM\Column(name="id", type="guid")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="NAME", type="string", length=128, nullable=true)
     */
    private $name;


    /**
     * @var boolean
     *
     * @ORM\Column(name="special", type="boolean", nullable=true)
     */
    private $special;


    /**
     * @var string
     *
     * @ORM\Column(name="hierarchyname", type="text", nullable=true)
     */
    private $hierarchyName;


    /**
     * @ORM\OneToMany(targetEntity="ProductCategory", mappedBy="parent")
     * @ORM\OrderBy({"name" = "ASC"})
     */
    private $children;

    /**
     * @ORM\ManyToOne(targetEntity="ProductCategory", inversedBy="children")
     * @ORM\JoinColumn(name="parent_category_id", referencedColumnName="id")
     */
    private $parent;



    /**
     * @var string
     *
     * @ORM\Column(name="notes", type="text", nullable=true)
     */
    private $notes;

    public function __construct()
    {
       $this->children = new ArrayCollection();
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

    public function getChildren($special=false)
    {
        $children = new ArrayCollection();
        foreach ($this->children as $child) {
            if ($child->special == $special) {
                $children->add($child);
            }
        }
        return $children;
    }

    public function jsonSerialize()
    {
        return array(
            'id' => $this->id,
            'name'=> $this->name,
            'children'=> $this->getChildren(false)->toArray(),
            // 'children'=> $this->children->toArray(),
            // 'parent'=> $this->parent,
            'notes'=> $this->notes,
        );
    }
}

