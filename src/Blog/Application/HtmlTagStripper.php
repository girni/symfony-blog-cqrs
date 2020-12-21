<?php
declare(strict_types=1);

namespace App\Blog\Application;

final class HtmlTagStripper
{
    private const HTML_ALLOWED_TAGS = [
        'ul',
        'li',
        'ol',
        'p',
        'strong'
    ];

    /**
     * @param string $content
     * @param array|null $allowedTags
     * @return string
     */
    public function stripeTags(string $content, ?array $allowedTags = null): string
    {
        if ($allowedTags === null) {
            $allowedTags = self::HTML_ALLOWED_TAGS;
        }

        return strip_tags($content, $allowedTags);
    }
}