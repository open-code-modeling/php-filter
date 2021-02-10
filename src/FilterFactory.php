<?php

/**
 * @see       https://github.com/open-code-modeling/php-filter for the canonical source repository
 * @copyright https://github.com/open-code-modeling/php-filter/blob/master/COPYRIGHT.md
 * @license   https://github.com/open-code-modeling/php-filter/blob/master/LICENSE.md MIT License
 */

declare(strict_types=1);

namespace OpenCodeModeling\Filter;

use Laminas\Filter;
use Laminas\Filter\FilterChain;
use Laminas\Filter\Word\SeparatorToSeparator;
use OpenCodeModeling\Filter\Filter\LowerCaseFirst;
use OpenCodeModeling\Filter\Filter\NormalizeLabel;
use OpenCodeModeling\Filter\Filter\UpperCaseFirst;
use OpenCodeModeling\Filter\Filter\UpperToLower;

final class FilterFactory
{
    /**
     * Returns a normalize filter for labels, names ...
     *
     * @param  callable ...$callables Attached to the end of the filter chain
     * @return callable
     */
    public static function normalizeFilter(callable ...$callables): callable
    {
        $filter = new Filter\FilterChain();
        $filter->attach(new NormalizeLabel());

        foreach ($callables as $callable) {
            $filter->attach($callable);
        }

        return $filter;
    }

    /**
     * Returns a filter for valid class names e.g. AddBuilding
     *
     * @return callable
     */
    public static function classNameFilter(): callable
    {
        return new UpperCaseFirst(
            self::normalizeFilter(
                new Filter\Word\CamelCaseToUnderscore(),
                new Filter\StringToLower(),
                new Filter\Word\UnderscoreToCamelCase(),
                new Filter\Word\SeparatorToSeparator(' ', '-'),
                new Filter\Word\DashToCamelCase()
            )
        );
    }

    /**
     * Returns a filter for valid constant names e.g. ADD_BUILDING
     *
     * @return callable
     */
    public static function constantNameFilter(): callable
    {
        return self::normalizeFilter(
            new Filter\Word\SeparatorToSeparator(' ', '-'),
            new Filter\Word\DashToCamelCase(),
            new Filter\Word\CamelCaseToUnderscore(),
            new Filter\StringToUpper()
        );
    }

    /**
     * Returns a filter for constant values e.g. add_building
     *
     * @return callable
     */
    public static function constantValueFilter(): callable
    {
        return self::normalizeFilter(
            new Filter\Word\SeparatorToSeparator(' ', '-'),
            new Filter\Word\DashToCamelCase(),
            new Filter\Word\CamelCaseToUnderscore(),
            new Filter\StringToLower()
        );
    }

    /**
     * Returns a filter for valid property names e.g. addBuilding
     *
     * @return callable
     */
    public static function propertyNameFilter(): callable
    {
        return new LowerCaseFirst(
            self::normalizeFilter(
                new Filter\Word\CamelCaseToUnderscore(),
                new Filter\StringToLower(),
                new Filter\Word\UnderscoreToCamelCase(),
                new Filter\Word\SeparatorToSeparator(' ', '-'),
                new Filter\Word\DashToCamelCase()
            )
        );
    }

    /**
     * Returns a filter for valid property names e.g. addBuilding
     *
     * @return callable
     */
    public static function methodNameFilter(): callable
    {
        return new LowerCaseFirst(
            self::normalizeFilter(
                new Filter\Word\CamelCaseToUnderscore(),
                new Filter\StringToLower(),
                new Filter\Word\UnderscoreToCamelCase(),
                new Filter\Word\SeparatorToSeparator(' ', '-'),
                new Filter\Word\DashToCamelCase(),
                new UpperToLower()
            )
        );
    }

    /**
     * Returns a filter for converting a directory to a namespace
     *
     * @return callable
     */
    public static function directoryToNamespaceFilter(): callable
    {
        $filter = new Filter\FilterChain();
        $filter->attach(new Filter\Word\SeparatorToSeparator(DIRECTORY_SEPARATOR, '|'));
        $filter->attach(new Filter\Word\SeparatorToSeparator('|', '\\\\'));

        return $filter;
    }

    /**
     * Returns a filter for converting a namespace to a directory
     *
     * @return callable
     */
    public static function namespaceToDirectoryFilter(): callable
    {
        $filter = new FilterChain();
        $filter->attach(new SeparatorToSeparator('\\', '|'));
        $filter->attach(new SeparatorToSeparator('|', DIRECTORY_SEPARATOR));

        return $filter;
    }
}
