Symfony Form SoftDeleteAware EntityType UX Autocomplete
========================================================

![Tests status](https://github.com/ideaconnect/symfony-form-soft-delete-aware-entity-type-ux-autocomplete/actions/workflows/run-tests.yml/badge.svg "Tests status")
![Code Coverate](https://coveralls.io/repos/github/ideaconnect/symfony-form-soft-delete-aware-entity-type-ux-autocomplete/badge.svg?branch=main "Code coverage status")

The missing link between `softdeleteable` from [doctrine/extensions](https://github.com/doctrine-extensions/DoctrineExtensions), Symfony Form component and
Symfony UX Autocomplete.

# Warning!

If you need to use this it most likely means that you have a bad architecture of your software. If you allow deletion or soft deletion you should first make sure
that each related entity is updated first with `null` or new relation. This form type is meant to be used for transition purposes in systems which need to quickly
add soft deletion on some entities which are used in relations, but due to time or other resources it is impossible to upgrade the actual processes.

## Purpose

If you are using the `softdeleteable` filter and `EntityType` forms you may encounter a situation when your CRUD Edit form in which the related entity is no longer
available as soft removed. This form type will make the form still properly render, but forcing the user to update the relation using the form.

In such situation, using standard entity type you may see a screen like this:

![Entity of type 'App\Entity\DeletableEntity' for IDs id\(1\) was not found](.github/images/1.png "Error message")

If you install package [idct/symfony-form-soft-delete-aware-entity-type](https://github.com/ideaconnect/symfony-form-soft-delete-aware-entity-type) and use the
`SoftDeleteAwareEntityType` it will revert to the placeholder forcing user to update:

![Success with the plugin](.github/images/2.png "Success")

This package, extension, add support for handling the same way soft deleted entities with `symfony/ux-autocomplete`


## Compatibility

* Symfony 6 or 7.
* Sonata Admin 3+

## Installation

First require it in your project:

```bash
composer require idct/symfony-form-soft-delete-aware-entity-type-ux-type
```

NOTE: you need to also configure `idct/symfony-form-soft-delete-aware-entity-type`.

As this is not a bundle register in your `services` (for example `services.yaml`) file:

If you have autowiring:
```yaml
    IDCT\SymfonyFormSoftDeleteAwareEntityType\SoftDeleteAwareEntityType: ~
    IDCT\SymfonyFormSoftDeleteAwareEntityType\Ux\BaseSoftDeleteEntityAutocompleteType: ~
```

If you do not use autowiring you need to pass doctrine as the first argument:

```yaml
    IDCT\SymfonyFormSoftDeleteAwareEntityType\SoftDeleteAwareEntityType:
        arguments:
            - '@doctrine'

    IDCT\SymfonyFormSoftDeleteAwareEntityType\Ux\BaseSoftDeleteEntityAutocompleteType: ~
        arguments:
            - '@doctrine'
```

Now create your autocomplete Form Type class, same as with UX Autocomplete, but use the parent coming out of this package:

```php
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
```

And that is all! The rest is normal form usage.

# Testing

Tool has a testing toolchain prepared using Docker. If you have docker installed simply run `./run-tests.sh`.

This will run unit tests with PHPUnit, generate code-coverage report and run some functional e-2-e tests using Behat and Chrome Driver.

# Contribution

Any contribution is more then welcome, please file any issues or pull requests, yet when possible please try to make sure that tests are working.