<?php

/**
 * File that defines the PreRemoveBlockTypeListener class.
 *
 * @author    Damien DE SOUSA
 * @copyright 2022
 */

namespace App\EventListener\BlockType;

use App\Entity\Structure\BlockType;
use App\Exception\Entity\DeleteEntityException;
use Doctrine\Persistence\Event\LifecycleEventArgs;

/**
 * Class listening on doctrine preRemove block type event.
 */
class PreRemoveBlockTypeListener
{
    public function preRemove(BlockType $blockType, LifecycleEventArgs $lifecycleEventArgs): void
    {
        if (count($blockType->getPageTemplateBlockTypes()) !== 0) {
            $exceptionMessage = 'BlockType with id ' . $blockType->getId() . ' cannot be deleted because it is linked'
                . 'to ' . count($blockType->getPageTemplateBlockTypes()) . ' PageTemplateBlockType';
            throw new DeleteEntityException(
                'block-type.delete.exception.linked-page-template',
                ['blockTypeType' => $blockType->getType()],
                $exceptionMessage
            );
        }
    }
}
