<?php

namespace App\Blog\Application\Query;

use App\Blog\Domain\Content;
use App\Blog\Domain\Image;
use App\Blog\Domain\PostId;
use App\Blog\Domain\Title;

final class PostView
{
    private PostId $id;
    private Title $title;
    private Content $content;
    private Image $image;

    public function __construct(PostId $id, Title $title, Content $content, Image $image)
    {
        $this->id = $id;
        $this->title = $title;
        $this->content = $content;
        $this->image = $image;
    }

    public function id(): string
    {
        return $this->id->asString();
    }

    public function title(): string
    {
        return $this->title->asString();
    }

    public function content(): string
    {
        return $this->content->asString();
    }

    public function image(): string
    {
        return $this->image->asString();
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id(),
            'title' => $this->title(),
            'content' => $this->content(),
            'image' => '/uploads/posts/' . $this->image()
        ];
    }
}