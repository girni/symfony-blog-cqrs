<?php
declare(strict_types=1);

namespace App\Blog\Domain;

use Assert\Assert;

final class Title
{
    private string $title;

    public function __construct(string $title)
    {
        Assert::that($title)->string();
        Assert::that($title)->minLength(10);
        Assert::that($title)->maxLength(80);

        $this->title = $title;
    }

    public static function fromString(string $title): self
    {
        return new self($title);
    }

    public function asString(): string
    {
        return $this->title;
    }
}