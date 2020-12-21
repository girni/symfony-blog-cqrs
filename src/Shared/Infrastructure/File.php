<?php
declare(strict_types=1);

namespace App\Shared\Infrastructure;

use Assert\Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;

final class File
{
    private $file;

    public function __construct($file)
    {
        $this->file = $file;
    }

    public function isUploadedFile(): bool
    {
        return $this->file instanceof UploadedFile;
    }

    /**
     * @return UploadedFile|string
     */
    public function file()
    {
        return $this->file;
    }

    /**
     * @param UploadedFile $file
     * @return static
     */
    public static function createFromUploadedFile(UploadedFile $file): self
    {
        return new self($file);
    }

    /**
     * @param string $file
     * @return static
     */
    public static function createFromUrl(string $file): self
    {
        Assert::that($file)->url();

        return new self($file);
    }
}