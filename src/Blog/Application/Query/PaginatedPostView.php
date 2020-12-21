<?php

namespace App\Blog\Application\Query;

final class PaginatedPostView
{
    /** @var PostView[]  */
    private array $posts;
    private int $currentPage;
    private int $total;

    public function __construct(array $posts, int $currentPage, int $total)
    {
        $this->posts = $posts;
        $this->currentPage = $currentPage;
        $this->total = $total;
    }

    /**
     * @return PostView[]
     */
    public function posts(): array
    {
        return $this->posts;
    }

    /**
     * @return int
     */
    public function currentPage(): int
    {
        return $this->currentPage;
    }

    /**
     * @return int
     */
    public function total(): int
    {
        return $this->total;
    }
}