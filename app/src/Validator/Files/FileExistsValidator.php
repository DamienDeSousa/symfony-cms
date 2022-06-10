<?php

/**
 * File that defines the FileExistsValidator validator class.
 *
 * @author    Damien DE SOUSA
 * @copyright 2022
 */

declare(strict_types=1);

namespace App\Validator\Files;

use Doctrine\Persistence\ObjectManager;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Filesystem\Filesystem;
use Doctrine\Persistence\Mapping\ClassMetadata;
use App\Repository\GroupedByRepositoryInterface;
use Symfony\Component\Validator\ConstraintValidator;
use App\Form\Type\Admin\BlockType\CreateBlockTypeType;
use Symfony\Contracts\Translation\TranslatorInterface;
use App\Controller\Admin\BlockType\BlockTypeCRUDController;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\ConstraintDefinitionException;

/**
 * Class used to validate if a file exists.
 */
class FileExistsValidator extends ConstraintValidator
{
    /** @var Filesystem */
    private $filesystem;

    /** @var TranslatorInterface */
    private $translator;

    /** @var string */
    private $directoryPath;

    public function __construct(Filesystem $filesystem, TranslatorInterface $translator, string $directoryPath)
    {
        $this->translator = $translator;
        $this->filesystem = $filesystem;
        $this->directoryPath = $directoryPath;
    }

    public function validate($value, Constraint $constraint)
    {
        if (!$constraint instanceof FileExists) {
            throw new UnexpectedTypeException($constraint, FileExists::class);
        }

        $file = $this->directoryPath . BlockTypeCRUDController::FORM_TYPE_BLOCK_RELATIVE_PATH . '/' . $value;
        if (
            !$value
            || !$this->filesystem->exists(
                $file
            )
        ) {
            $this->context
                ->buildViolation($this->translator->trans($constraint->message, ['file' => $file]))
                ->addViolation();
        }
    }
}
