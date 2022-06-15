<?php

/**
 * File that defines the PageTemplateBlockType entity.
 * This entity make this link between a page template entity and a block type entity.
 *
 * @author    Damien DE SOUSA <desousadamien30@gmail.com>
 * @copyright 2021 Damien DE SOUSA
 */

declare(strict_types=1);

namespace App\Entity\Structure;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use App\Repository\Structure\PageTemplateBlockTypeRepository;

#[ORM\Entity(repositoryClass: PageTemplateBlockTypeRepository::class)]
#[UniqueEntity(fields: ["slug", "pageTemplate", "blockType"], errorPath: "slug")]
class PageTemplateBlockType
{
    #[ORM\Id, ORM\Column(type: "integer"), ORM\GeneratedValue]
    private ?int $id;

    #[ORM\Column(type: "string", length: 50)]
    #[Assert\NotBlank]
    private ?string $slug;

    #[ORM\ManyToOne(targetEntity: "App\Entity\Structure\PageTemplate", inversedBy: "pageTemplateBlockTypes")]
    #[ORM\JoinColumn(name: "page_template_id", referencedColumnName: "id", onDelete: "CASCADE")]
    #[Assert\NotNull]
    private ?PageTemplate $pageTemplate;

    #[ORM\ManyToOne(targetEntity: "App\Entity\Structure\BlockType", inversedBy: "pageTemplateBlockTypes")]
    #[ORM\JoinColumn(name: "block_type_id", referencedColumnName: "id")]
    #[Assert\NotNull]
    private ?BlockType $blockType;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(?string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getPageTemplate(): ?PageTemplate
    {
        return $this->pageTemplate;
    }

    public function setPageTemplate(?PageTemplate $pageTemplate): self
    {
        $this->pageTemplate = $pageTemplate;

        return $this;
    }

    public function getBlockType(): ?BlockType
    {
        return $this->blockType;
    }

    public function setBlockType(?BlockType $blockType): self
    {
        $this->blockType = $blockType;

        return $this;
    }
}
