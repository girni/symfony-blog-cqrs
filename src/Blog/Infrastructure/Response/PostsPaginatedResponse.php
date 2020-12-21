<?php
declare(strict_types=1);

namespace App\Blog\Infrastructure\Response;

use App\Blog\Application\Query\PaginatedPostView;
use App\Blog\Application\Query\PostView;

class PostsPaginatedResponse
{
    public static function create(PaginatedPostView $paginatedPostView): array
    {
        return [
            'data' => [
                'posts' => array_map(fn(PostView $post) => $post->toArray(), $paginatedPostView->posts()),
                'currentPage' => $paginatedPostView->currentPage(),
                'total' => $paginatedPostView->total()
            ]
        ];
    }
}