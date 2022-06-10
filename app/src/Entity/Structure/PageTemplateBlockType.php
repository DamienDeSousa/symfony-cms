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
use App\Validator\Classes as CmsAssert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use App\Repository\Structure\PageTemplateBlockTypeRepository;

/**
 * @ORM\Entity(repositoryClass=PageTemplateBlockTypeRepository::class)
 *
 * @UniqueEntity(
 *     fields={"slug", "pageTemplate", "blockType"},
 *     errorPath="slug"
 * )
 */
class PageTemplateBlockType
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
     * @ORM\Column(type="string", length=50)
     *
     * @Assert\NotBlank
     */
    private $slug;

    /**
     * @var PageTemplate
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Structure\PageTemplate", inversedBy="pageTemplateBlockTypes")
     * @ORM\JoinColumn(name="page_template_id", referencedColumnName="id", onDelete="CASCADE")
     *
     * @Assert\NotNull
     */
    private $pageTemplate;

    /**
     * @var BlockType
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Structure\BlockType", inversedBy="pageTemplateBlockTypes")
     * @ORM\JoinColumn(name="block_type_id", referencedColumnName="id")
     *
     * @Assert\NotNull
     */
    private $blockType;

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

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'slug' => $this->slug,
            'pageTemplate' => $this->pageTemplate->getName(),
            'blockType' => $this->blockType->getType(),
        ];
    }
}
