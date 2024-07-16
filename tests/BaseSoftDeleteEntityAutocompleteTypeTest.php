<?php

declare(strict_types=1);

namespace IDCT\Tests\SymfonyFormSoftDeleteAwareEntityType\Ux;

use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\Mapping\ClassMetadata;
use Doctrine\Persistence\ObjectManager;
use IDCT\SymfonyFormSoftDeleteAwareEntityType\SoftDeleteAwareEntityType;
use IDCT\SymfonyFormSoftDeleteAwareEntityType\SoftDeleteAwareIdReader;
use IDCT\SymfonyFormSoftDeleteAwareEntityType\Ux\BaseSoftDeleteEntityAutocompleteType;
use IDCT\Tests\SymfonyFormSoftDeleteAwareEntityType\Model\DummyEntity;
use IDCT\Tests\SymfonyFormSoftDeleteAwareEntityType\Model\DummyOptions;
use IDCT\Tests\SymfonyFormSoftDeleteAwareEntityType\Service\DummyOptionsResolver;
use PHPUnit\Framework\TestCase;
use ReflectionClass;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\UX\Autocomplete\Form\BaseEntityAutocompleteType;

final class BaseSoftDeleteEntityAutocompleteTypeTest extends TestCase
{
    private function accessProtected($obj, $prop) {
        $reflection = new ReflectionClass($obj);
        $property = $reflection->getProperty($prop);
        $property->setAccessible(true);
        return $property->getValue($obj);
    }

    public function testInitPassed(): void
    {
        $urlGenerator = $this->createMock(UrlGeneratorInterface::class);
        $type = new BaseSoftDeleteEntityAutocompleteType($urlGenerator);
        $decorated = $this->accessProtected($type, 'decorated');
        $this->assertTrue($decorated instanceof BaseEntityAutocompleteType);
    }

    public function testGetParent(): void {
        $urlGenerator = $this->createMock(UrlGeneratorInterface::class);
        $type = new BaseSoftDeleteEntityAutocompleteType($urlGenerator);
        $this->assertEquals(SoftDeleteAwareEntityType::class, $type->getParent());
    }

    public function testGetBlockPrefix(): void {
        $urlGenerator = $this->createMock(UrlGeneratorInterface::class);
        $type = new BaseSoftDeleteEntityAutocompleteType($urlGenerator);
        $decorated = $this->accessProtected($type, 'decorated');
        $this->assertSame($decorated->getBlockPrefix(), $type->getBlockPrefix());
    }

    public function testConfigureOptions(): void {
        $urlGenerator = $this->createMock(UrlGeneratorInterface::class);
        $type = new BaseSoftDeleteEntityAutocompleteType($urlGenerator);
        $optionsResolver = new OptionsResolver();
        $type->configureOptions($optionsResolver);
        $this->assertTrue(in_array('autocomplete', $optionsResolver->getDefinedOptions()));
    }

    public function testBuildForm(): void {
        $urlGenerator = $this->createMock(UrlGeneratorInterface::class);
        $type = new BaseSoftDeleteEntityAutocompleteType($urlGenerator);

        $options = ['autocomplete_url' => 'test123'];
        $builder = $this->getMockBuilder(FormBuilder::class)
                    ->disableOriginalConstructor()
                    ->onlyMethods([])
                    ->getMock();

        $type->buildForm($builder, $options);
        $this->assertSame($builder->getAttribute('autocomplete_url'), 'test123');
    }
}
