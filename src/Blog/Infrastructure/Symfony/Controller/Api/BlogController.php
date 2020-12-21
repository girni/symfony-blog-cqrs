<?php
declare(strict_types=1);

namespace App\Blog\Infrastructure\Symfony\Controller\Api;

use App\Blog\Application\CreatePostCommand;
use App\Blog\Application\Query\PostQuery;
use App\Blog\Infrastructure\Response\PostResponse;
use App\Blog\Infrastructure\Response\PostsPaginatedResponse;
use App\Blog\Infrastructure\Symfony\Form\CreateBlogForm;
use App\Shared\Infrastructure\CommandBus;
use App\Shared\Infrastructure\File;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Asset\Packages;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class BlogController extends AbstractController
{
    /**
     * @var CommandBus
     */
    private CommandBus $commandBus;

    /**
     * @var PostQuery
     */
    private PostQuery $postQuery;

    /**
     * @var Packages
     */
    private Packages $assetsManager;

    public function __construct(
        CommandBus $commandBus,
        PostQuery $postQuery,
        Packages $assetsManager
    ) {
        $this->commandBus = $commandBus;
        $this->postQuery = $postQuery;
        $this->assetsManager = $assetsManager;
    }

    /**
     * @Route("/api/blog", name="api_blog_index", methods={"GET"})
     */
    public function index(Request $request): JsonResponse
    {
        $posts = $this->postQuery->paginate(
            $request->query->get('page', 1),
            $request->query->get('limit', 10)
        );

        return $this->json(PostsPaginatedResponse::create($posts), Response::HTTP_OK);
    }

    /**
     * @Route("/api/blog/{postId}", name="api_blog_show", methods={"GET"})
     */
    public function show(string $postId): JsonResponse
    {
        $post = $this->postQuery->findById($postId);

        return $this->json(PostResponse::create($post), Response::HTTP_OK);
    }

    /**
     * @Route("/api/blog/create", name="api_blog_create", methods={"POST"})
     */
    public function create(Request $request): JsonResponse
    {
        $form = $this->createForm(
            CreateBlogForm::class,
            null,
            [
                'csrf_protection' => false
            ]
        );

        $form->submit($request->request->all() + $request->files->all());

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $this->commandBus->handle(
                new CreatePostCommand(
                    $data['title'],
                    $data['content'],
                    File::createFromUploadedFile($data['image'])
                )
            );
        }

        return $this->json([], Response::HTTP_CREATED);
    }
}