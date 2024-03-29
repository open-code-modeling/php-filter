<?php

/**
 * @see       https://github.com/open-code-modeling/php-filter for the canonical source repository
 * @copyright https://github.com/open-code-modeling/php-filter/blob/master/COPYRIGHT.md
 * @license   https://github.com/open-code-modeling/php-filter/blob/master/LICENSE.md MIT License
 */

declare(strict_types=1);

namespace OpenCodeModeling\Filter\Filter;

final class NormalizeLabel extends AbstractFilter
{
    public function __invoke(string $value): string
    {
        // Special rule: Remove everything after the first horizontal line
        $matches = [];
        if (\preg_match('/<hr id="null"[^>]*>/', $value, $matches)) {
            return \explode($matches[0], $value)[0];
        }

        // Remove all html tags and styles
        $normalizedName = \strip_tags(\html_entity_decode($value));

        // Replace the decoded nbsp UTF-8 space with a "normal" space
        $normalizedName = \str_replace("\xc2\xa0", ' ', $normalizedName);

        // Strip multi-spaces and tabs with a single space
        $normalizedName = \preg_replace(['/\s{2,}/', '/[\t\n]/'], ' ', $normalizedName);

        return \trim(\trim($normalizedName), '/');
    }
}
