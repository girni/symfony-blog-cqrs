<?php

namespace App\Blog\Infrastructure;

use App\Blog\Domain\Post;
use App\Blog\Domain\PostRepository;
use Doctrine\ORM\EntityManagerInterface;

final class DoctrineOrmPostRepository implements PostRepository
{
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function add(Post $post): void
    {
        $this->entityManager->persist($post);
        $this->entityManager->flush();
    }
}