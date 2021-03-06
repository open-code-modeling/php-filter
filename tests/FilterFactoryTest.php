<?php

declare(strict_types=1);

namespace OpenCodeModelingTest\Filter;

use Generator;
use OpenCodeModeling\Filter\FilterFactory;
use PHPUnit\Framework\TestCase;

final class FilterFactoryTest extends TestCase
{
    /**
     * @return Generator<string, array>
     */
    public function providerForLabel(): Generator
    {
        yield 'add building' => ['add building'];
        yield 'add_building' => ['add_building'];
        yield 'add-building' => ['add-building'];
        yield 'addBuilding' => ['addBuilding'];
        yield 'AddBuilding' => ['AddBuilding'];
        yield ' Add Building ' => [' Add Building '];
        yield 'Add building ' => ['Add building '];
        yield 'html' => ['Add Building<hr id="null"><div style="text-align: left;">- buildingId: string</div><div style="text-align: left;">- name: string</div>'];
    }

    /**
     * @test
     * @dataProvider providerForLabel
     * @param string $label
     */
    public function it_filters_method_name(string $label): void
    {
        $filter = FilterFactory::methodNameFilter();
        $this->assertSame('addBuilding', ($filter)($label));
    }

    /**
     * @test
     */
    public function it_filters_method_name_with_only_upper_letters(): void
    {
        $filter = FilterFactory::methodNameFilter();
        $this->assertSame('ny', ($filter)('NY'));
    }

    /**
     * @test
     * @dataProvider providerForLabel
     * @param string $label
     */
    public function it_filters_property_name(string $label): void
    {
        $filter = FilterFactory::propertyNameFilter();
        $this->assertSame('addBuilding', ($filter)($label));
    }

    /**
     * @test
     * @dataProvider providerForLabel
     * @param string $label
     */
    public function it_filters_constant_name(string $label): void
    {
        $filter = FilterFactory::constantNameFilter();
        $this->assertSame('ADD_BUILDING', ($filter)($label));
    }

    /**
     * @test
     * @dataProvider providerForLabel
     * @param string $label
     */
    public function it_filters_constant_value(string $label): void
    {
        $filter = FilterFactory::constantValueFilter();
        $this->assertSame('add_building', ($filter)($label));
    }

    /**
     * @test
     * @dataProvider providerForLabel
     * @param string $label
     */
    public function it_filters_class_name(string $label): void
    {
        $filter = FilterFactory::classNameFilter();
        $this->assertSame('AddBuilding', ($filter)($label));
    }

    /**
     * @test
     */
    public function it_filters_namespace_to_directory(): void
    {
        $filter = FilterFactory::namespaceToDirectoryFilter();
        $this->assertSame('My/App/Service', ($filter)('My\\App\\Service'));
    }

    /**
     * @test
     */
    public function it_filters_directory_to_namespace(): void
    {
        $filter = FilterFactory::directoryToNamespaceFilter();
        $this->assertSame('My\\App\\Service', ($filter)('My/App/Service'));
    }
}
