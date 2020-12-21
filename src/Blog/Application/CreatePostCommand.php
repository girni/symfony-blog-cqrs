<?php
declare(strict_types=1);

namespace App\Blog\Application;

use App\Shared\Application\Command;
use App\Shared\Infrastructure\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;

final class CreatePostCommand implements Command
{
    private string $title;
    private string $content;
    private File $image;

    public function __construct(string $title, string $content, File $image)
    {
        $this->title = $title;
        $this->content = $content;
        $this->image = $image;
    }

    public function title(): string
    {
        return $this->title;
    }

    public function content(): string
    {
        return $this->content;
    }

    public function image(): File
    {
        return $this->image;
    }
}