<?php

namespace App\Blog\Infrastructure;

use App\Blog\Application\Query\PaginatedPostView;
use App\Blog\Application\Query\PostNotFoundException;
use App\Blog\Application\Query\PostQuery;
use App\Blog\Application\Query\PostView;
use App\Blog\Domain\Content;
use App\Blog\Domain\Image;
use App\Blog\Domain\PostId;
use App\Blog\Domain\Title;
use Doctrine\DBAL\Connection;
use Doctrine\ORM\Tools\Pagination\Paginator;

final class DbalPostQuery implements PostQuery
{
    /**
     * @var Connection
     */
    private Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function findById(string $postId): PostView
    {
        $queryBuilder = $this->connection->createQueryBuilder();
        $queryBuilder
            ->select('p.id', 'p.title', 'p.content', 'p.image')
            ->from('posts', 'p')
            ->where('p.id = :postId')
            ->setParameter('postId', $postId);

        $postData = $this->connection->fetchAssociative($queryBuilder->getSQL(), $queryBuilder->getParameters());

        if ($postData === false) {
            throw new PostNotFoundException(404, 'Post with given id doesn\'t exists');
        }

        return new PostView(
            PostId::fromString($postData['id']),
            Title::fromString($postData['title']),
            Content::fromString($postData['content']),
            Image::fromPath($postData['image'])
        );
    }

    public function paginate(int $page = 1, int $limit = 10): PaginatedPostView
    {
        $queryBuilder = $this->connection->createQueryBuilder();

        $offset = 0;
        $limit = $limit >= 15 ? 15 : $limit;

        if ($page !== 0 && $page !== 1) {
            $offset = ($page - 1) * $limit;
        }

        $queryBuilder
            ->select('p.id', 'p.title', 'p.content', 'p.image')
            ->from('posts', 'p')
            ->setFirstResult($offset)
            ->setMaxResults($limit);

        $posts = $this->connection->fetchAllAssociative($queryBuilder->getSQL());

        $queryBuilder = $this->connection->createQueryBuilder();
        $queryBuilder
            ->select('count(p.id)')
            ->from('posts', 'p');

        $count = $this->connection->fetchOne($queryBuilder->getSQL());

        return new PaginatedPostView(
            array_map(
                function (array $postData) {
                    return new PostView(
                        PostId::fromString($postData['id']),
                        Title::fromString($postData['title']),
                        Content::fromString($postData['content']),
                        Image::fromPath($postData['image'])
                    );
                },
                $posts
            ),
            $page,
            $count
        );
    }

}