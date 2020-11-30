<?php

/**
 * @see       https://github.com/open-code-modeling/php-filter for the canonical source repository
 * @copyright https://github.com/open-code-modeling/php-filter/blob/master/COPYRIGHT.md
 * @license   https://github.com/open-code-modeling/php-filter/blob/master/LICENSE.md MIT License
 */

declare(strict_types=1);

namespace OpenCodeModeling\Filter\Filter;

final class UpperCaseFirst extends AbstractFilter
{
    public function __invoke(string $value): string
    {
        return \ucfirst(($this->filter)($value));
    }
}
