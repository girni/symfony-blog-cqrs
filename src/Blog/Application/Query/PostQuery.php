<?php

namespace App\Blog\Application\Query;

interface PostQuery
{
    public function findById(string $postId): PostView;

    public function paginate(int $page = 1, int $limit = 10): PaginatedPostView;
}