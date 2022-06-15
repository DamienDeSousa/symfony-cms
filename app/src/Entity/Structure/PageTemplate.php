<?php

/**
 * File that defines the PageTemplate entity. This entity represents a page template.
 *
 * @author    Damien DE SOUSA <desousadamien30@gmail.com>
 * @copyright 2021 Damien DE SOUSA
 */

declare(strict_types=1);

namespace App\Entity\Structure;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use App\Repository\Structure\PageTemplateRepository;
use JetBrains\PhpStorm\Pure;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: PageTemplateRepository::class)]
#[UniqueEntity(fields: "name", message: "page-template.create.error.name")]
#[UniqueEntity(fields: "layout", message: "page-template.create.error.layout")]
class PageTemplate
{
    #[ORM\Id, ORM\Column(type: "integer"), ORM\GeneratedValue]
    private ?int $id;

    #[ORM\Column(type: "string", length: 255, unique: true)]
    #[Assert\NotBlank]
    #[Assert\Type("string")]
    private ?string $name;

    #[ORM\Column(type: "string", length: 255, unique: true)]
    #[Assert\NotBlank]
    #[Assert\Type("string")]
    private ?string $layout;

    #[ORM\OneToMany(
        mappedBy: "pageTemplate",
        targetEntity: "App\Entity\Structure\PageTemplateBlockType",
        cascade: ["remove"]
    )]
    private Collection $pageTemplateBlockTypes;

    #[Pure]
    public function __construct()
    {
        $this->pageTemplateBlockTypes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

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

    public function __toString(): string
    {
        return $this->name;
    }
}
