<?php
declare(strict_types=1);

namespace App\Blog\Domain;

use Assert\Assert;

final class Content
{
    private string $content;

    public function __construct(string $content)
    {
        Assert::that($content)->string();
        Assert::that($content)->minLength(20);

        $this->content = $content;
    }

    public static function fromString(string $content): self
    {
        return new self($content);
    }

    /**
     * @return string
     */
    public function asString(): string
    {
        return $this->content;
    }

}