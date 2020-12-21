<?php
declare(strict_types=1);

namespace App\Blog\Domain;

use Assert\Assert;

final class Image
{
    private string $image;

    public function __construct(string $image)
    {
        Assert::that($image)->string();

        $this->image = $image;
    }

    public static function fromPath(string $imagePath): self
    {
        return new self($imagePath);
    }

    public function asString(): string
    {
        return $this->image;
    }
}