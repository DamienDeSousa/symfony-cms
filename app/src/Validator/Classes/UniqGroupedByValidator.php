<?php

/**
 * File that defines the UniqGroupedByValidator validator class.
 *
 * @author    Damien DE SOUSA
 * @copyright 2022
 */

declare(strict_types=1);

namespace App\Validator\Classes;

use Doctrine\Persistence\ObjectManager;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Validator\Constraint;
use Doctrine\Persistence\Mapping\ClassMetadata;
use App\Repository\GroupedByRepositoryInterface;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\ConstraintDefinitionException;

/**
 * Class used to validate if attributes are uniq when grouped by (query clause).
 */
class UniqGroupedByValidator extends ConstraintValidator
{
    /** @var ManagerRegistry */
    private $registry;

    /** @var TranslatorInterface */
    private $translator;

    public function __construct(ManagerRegistry $registry, TranslatorInterface $translator)
    {
        $this->translator = $translator;
        $this->registry = $registry;
    }

    public function validate($entity, Constraint $constraint)
    {
        if (!$constraint instanceof UniqGroupedBy) {
            throw new UnexpectedTypeException($constraint, UniqGroupedBy::class);
        }

        $attributesGroupedBy = (array) $constraint->attributesGroupedBy;
        $uniqAttributes = (array) $constraint->uniqAttributes;
        $this->checkAttributes($attributesGroupedBy);
        $this->checkAttributes($uniqAttributes);

        $entityManager = $this->registry->getManagerForClass(\get_class($entity));
        if (!$entityManager) {
            throw new ConstraintDefinitionException(
                sprintf(
                    'Unable to find the object manager associated with an entity of class "%s".',
                    \get_class($entity)
                )
            );
        }

        $class = $entityManager->getClassMetadata(\get_class($entity));

        $groupedByCriteria = $this->buildCriteria($attributesGroupedBy, $class, $entity, $entityManager);
        $uniqCriteria = $this->buildCriteria($uniqAttributes, $class, $entity, $entityManager);

        // skip validation if there are no criteria (this can happen when the fields to be checked are null)
        if (empty($groupedByCriteria) || empty($uniqCriteria)) {
            return;
        }

        $repository = $entityManager->getRepository(\get_class($entity));
        if (!$repository instanceof GroupedByRepositoryInterface) {
            throw new UnexpectedTypeException(get_class($repository), GroupedByRepositoryInterface::class);
        }
        $result = $repository->findGroupedBy($uniqCriteria, $groupedByCriteria);

        if ($result instanceof \IteratorAggregate) {
            $result = $result->getIterator();
        }

        /* If the result is a MongoCursor, it must be advanced to the first
         * element. Rewinding should have no ill effect if $result is another
         * iterator implementation.
         */
        if ($result instanceof \Iterator) {
            $result->rewind();
            if ($result instanceof \Countable && 1 < \count($result)) {
                $result = [$result->current(), $result->current()];
            } else {
                $result = $result->valid() && null !== $result->current() ? [$result->current()] : [];
            }
        } elseif (\is_array($result)) {
            reset($result);
        } else {
            $result = null === $result ? [] : [$result];
        }

        /* If no entity matched the query criteria or a single entity matched,
         * which is the same as the entity being validated, the criteria is
         * unique.
         */
        if (!$result || (1 === \count($result) && current($result) === $entity)) {
            return;
        }

        $this->context->buildViolation($this->buildErrorMessage($constraint))
            ->addViolation();
    }

    private function buildErrorMessage(UniqGroupedBy $uniqGroupedByConstraint): string
    {
        return $this->translator->trans(
            'uniq_group_by',
            [
                'uniq_field_number' => count($uniqGroupedByConstraint->uniqAttributes),
                'uniq_fields' => implode(', ', $uniqGroupedByConstraint->uniqAttributes),
                'grouped_by_field_number' => count($uniqGroupedByConstraint->attributesGroupedBy),
                'grouped_by_fields' => implode(', ', $uniqGroupedByConstraint->attributesGroupedBy),
            ],
            'validators'
        );
    }

    private function checkAttributes(array $attributes): void
    {
        if (0 === \count($attributes)) {
            throw new ConstraintDefinitionException('At least one attribute has to be specified.');
        }
    }

    private function buildCriteria(
        array $attributes,
        ClassMetadata $class,
        $entity,
        ObjectManager $entityManager
    ): array {
        $criteria = [];

        foreach ($attributes as $attribute) {
            if (!$class->hasField($attribute) && !$class->hasAssociation($attribute)) {
                throw new ConstraintDefinitionException(
                    sprintf(
                        'The field "%s" is not mapped by Doctrine, so it cannot be validated for uniqueness.',
                        $attribute
                    )
                );
            }

            $fieldValue = $class->reflFields[$attribute]->getValue($entity);

            if ($fieldValue === null) {
                continue;
            }

            $criteria[$attribute] = $fieldValue;

            if (null !== $criteria[$attribute] && $class->hasAssociation($attribute)) {
                /* Ensure the Proxy is initialized before using reflection to
                 * read its identifiers. This is necessary because the wrapped
                 * getter methods in the Proxy are being bypassed.
                 */
                $entityManager->initializeObject($criteria[$attribute]);
            }
        }

        return $criteria;
    }
}
