<?php

/**
 * @see       https://github.com/open-code-modeling/php-filter for the canonical source repository
 * @copyright https://github.com/open-code-modeling/php-filter/blob/master/COPYRIGHT.md
 * @license   https://github.com/open-code-modeling/php-filter/blob/master/LICENSE.md MIT License
 */

declare(strict_types=1);

namespace OpenCodeModeling\Filter\Filter;

/**
 * @internal
 */
abstract class AbstractFilter implements Filter
{
    /**
     * @var callable
     **/
    protected $filter;

    public function __construct(callable $filter = null)
    {
        $this->filter = $filter ?? new Noop();
    }
}
