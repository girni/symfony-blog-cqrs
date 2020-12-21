<?php
declare(strict_types=1);

namespace App\Blog\Domain;

interface PostRepository
{
    public function add(Post $post): void;
}