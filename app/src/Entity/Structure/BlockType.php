<?php

/**
 * File that defines the BlockType class entity. This entity represent a block type.
 *
 * @author Damien DE SOUSA
 * @copyright 2021
 */

declare(strict_types=1);

namespace App\Entity\Structure;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use App\Repository\Structure\BlockTypeRepository;

/**
 * @ORM\Entity(repositoryClass=BlockTypeRepository::class)
 */
class BlockType
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $type;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="App\Entity\Structure\PageTemplateBlockType", mappedBy="pageTemplate")
     */
    private $pageTemplateBlockTypes;

    public function __construct()
    {
        $this->pageTemplateBlockTypes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getPageTemplateBlockTypes(): ArrayCollection
    {
        return $this->pageTemplateBlockTypes;
    }

    public function addPageTemplateBlockType(PageTemplateBlockType $pageTemplateBlockType): self
    {
        $this->pageTemplateBlockTypes->add($pageTemplateBlockType);

        return $this;
    }

    public function removePageTemplateBlockType(PageTemplateBlockType $pageTemplateBlockType): self
    {
        if ($this->pageTemplateBlockTypes->contains($pageTemplateBlockType)) {
            $this->pageTemplateBlockTypes->removeElement($pageTemplateBlockType);
        }

        return $this;
    }
}
