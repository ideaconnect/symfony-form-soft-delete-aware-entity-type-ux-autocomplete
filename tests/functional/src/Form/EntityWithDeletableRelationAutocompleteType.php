<?php

declare(strict_types=1);

namespace App\Form;

use App\Entity\DeletableEntity;
use IDCT\SymfonyFormSoftDeleteAwareEntityType\Ux\BaseSoftDeleteEntityAutocompleteType;
use Praetorian\Sportsbook\Orm\Entity\Currency;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\Autocomplete\Form\AsEntityAutocompleteField;

#[AsEntityAutocompleteField]
class EntityWithDeletableRelationAutocompleteType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'class' => DeletableEntity::class,
            'placeholder' => 'placeholder',
            'choice_label' => 'name'
        ]);
    }

    public function getParent(): string
    {
        return BaseSoftDeleteEntityAutocompleteType::class;
    }
}
