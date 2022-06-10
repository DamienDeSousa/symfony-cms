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
use Symfony\Component\Validator\Constraints as Assert;
use App\Repository\Structure\BlockTypeRepository;
use Doctrine\Common\Collections\Collection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use App\Validator\Files\FileExists;

/**
 * @ORM\Entity(repositoryClass=BlockTypeRepository::class)
 *
 * @UniqueEntity(fields="type", message="block-type.create.error.type")
 * @UniqueEntity(fields="layout", message="block-type.create.error.layout")
 */
class BlockType
{
    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=100, unique=true)
     *
     * @Assert\NotBlank
     * @Assert\Type("string")
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, unique=true)
     *
     * @Assert\NotBlank
     * @Assert\Type("string")
     */
    private $layout;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="App\Entity\Structure\PageTemplateBlockType", mappedBy="blockType")
     */
    private $pageTemplateBlockTypes;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=false)
     *
     * @Assert\NotBlank
     * @Assert\Type("string")
     * @FileExists
     */
    private $formType;

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

    public function setType(?string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getPageTemplateBlockTypes(): Collection
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

    public function getLayout(): ?string
    {
        return $this->layout;
    }

    public function setLayout(?string $layout): self
    {
        $this->layout = $layout;

        return $this;
    }

    public function getFormType(): ?string
    {
        return $this->formType;
    }

    public function setFormType(?string $formType): self
    {
        $this->formType = $formType;

        return $this;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'type' => $this->type,
            'layout' => $this->layout,
        ];
    }

    public function __toString(): string
    {
        return $this->type;
    }
}
