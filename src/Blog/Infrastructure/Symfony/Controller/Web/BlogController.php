<?php

namespace App\Blog\Infrastructure\Symfony\Controller\Web;

use App\Blog\Application\CreatePostCommand;
use App\Blog\Infrastructure\Symfony\Form\CreateBlogForm;
use App\Shared\Infrastructure\CommandBus;
use App\Shared\Infrastructure\File;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class BlogController extends AbstractController
{
    /**
     * @var CommandBus
     */
    private CommandBus $commandBus;

    public function __construct(CommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    /**
     * @Route("/", name="blog_index", methods={"GET"})
     */
    public function index()
    {
        return $this->render(
            'blog/index.html.twig',
            []
        );
    }

    /**
     * @Route("/blog/create", name="blog_create", methods={"GET", "POST"})
     */
    public function create(Request $request): Response
    {
        $form = $this->createForm(CreateBlogForm::class);
        $form = $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $this->commandBus->handle(
                new CreatePostCommand(
                    $data['title'],
                    $data['content'],
                    File::createFromUploadedFile($data['image'])
                )
            );

            return $this->redirectToRoute('blog_index');
        }

        return $this->render(
            'blog/create.html.twig',
            [
                'form' => $form->createView()
            ]
        );
    }
}