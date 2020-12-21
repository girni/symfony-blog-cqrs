<?php
declare(strict_types=1);

namespace App\Blog\Infrastructure\Response;

use App\Blog\Application\Query\PostView;

class PostResponse
{
    public static function create(PostView $postView): array
    {
        return [
            'data' => $postView->toArray()
        ];
    }
}