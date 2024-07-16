<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace IDCT\SymfonyFormSoftDeleteAwareEntityType\Ux;

use IDCT\SymfonyFormSoftDeleteAwareEntityType\SoftDeleteAwareEntityType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Exception\RuntimeException;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\UX\Autocomplete\Form\BaseEntityAutocompleteType;
use Symfony\UX\Autocomplete\Form\ChoiceList\Loader\ExtraLazyChoiceLoader;

/**
 * All form types that want to expose autocomplete functionality should use this for its getParent().
 */
final class BaseSoftDeleteEntityAutocompleteType extends AbstractType
{
    protected BaseEntityAutocompleteType $decorated;

    public function __construct(
        private UrlGeneratorInterface $urlGenerator,
    ) {
        $this->decorated = new BaseEntityAutocompleteType($urlGenerator);
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $this->decorated->buildForm($builder, $options);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $this->decorated->configureOptions($resolver);
    }

    public function getParent(): string
    {
        return SoftDeleteAwareEntityType::class;
    }

    public function getBlockPrefix(): string
    {
        return $this->decorated->getBlockPrefix();

    }
}