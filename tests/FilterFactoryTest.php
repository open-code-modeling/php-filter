<?php

/**
 * @see       https://github.com/open-code-modeling/php-filter for the canonical source repository
 * @copyright https://github.com/open-code-modeling/php-filter/blob/master/COPYRIGHT.md
 * @license   https://github.com/open-code-modeling/php-filter/blob/master/LICENSE.md MIT License
 */

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
        yield 'ADD_BUILDING' => ['ADD_BUILDING'];
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
    public function it_filters_snake_case(string $label): void
    {
        $filter = FilterFactory::snakeCaseFilter();
        $this->assertSame('add_building', ($filter)($label));
    }

    /**
     * @test
     * @dataProvider providerForLabel
     * @param string $label
     */
    public function it_filters_camel_case(string $label): void
    {
        $filter = FilterFactory::camelCaseFilter();
        $this->assertSame('addBuilding', ($filter)($label));
    }

    /**
     * @test
     * @dataProvider providerForLabel
     * @param string $label
     */
    public function it_filters_pascal_case(string $label): void
    {
        $filter = FilterFactory::pascalCaseFilter();
        $this->assertSame('AddBuilding', ($filter)($label));
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
