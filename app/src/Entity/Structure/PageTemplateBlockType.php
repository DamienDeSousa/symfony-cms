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
use App\Repository\Structure\PageTemplateBlockTypeRepository;

/**
 * @ORM\Entity(repositoryClass=PageTemplateBlockTypeRepository::class)
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
     */
    private $slug;

    /**
     * @var PageTemplate
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Structure\PageTemplate", inversedBy="pageTemplateBlockTypes")
     * @ORM\JoinColumn(name="page_template_id", referencedColumnName="id")
     */
    private $pageTemplate;

    /**
     * @var BlockType
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Structure\BlockType", inversedBy="pageTemplateBlockTypes")
     * @ORM\JoinColumn(name="block_type_id", referencedColumnName="id")
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

    public function setSlug(string $slug): self
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
