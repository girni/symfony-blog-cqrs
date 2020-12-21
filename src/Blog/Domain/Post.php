<?php
declare(strict_types=1);

namespace App\Blog\Domain;

final class Post
{
    private PostId $id;
    private Title $title;
    private Image $image;
    private Content $content;

    public function __construct(PostId $id, Title $title, Content $content, Image $image)
    {
        $this->id = $id;
        $this->title = $title;
        $this->image = $image;
        $this->content = $content;
    }
}