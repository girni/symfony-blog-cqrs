<?php

declare(strict_types=1);

namespace App\Blog\Application;

use App\Blog\Domain\Content;
use App\Blog\Domain\Image;
use App\Blog\Domain\Post;
use App\Blog\Domain\PostId;
use App\Blog\Domain\PostRepository;
use App\Blog\Domain\Title;
use App\Shared\Infrastructure\FileUploader;
use Ramsey\Uuid\Uuid;

final class CreatePostHandler
{
    /**
     * @var PostRepository
     */
    private PostRepository $posts;

    /**
     * @var FileUploader
     */
    private FileUploader $fileUploader;

    /**
     * @var HtmlTagStripper
     */
    private HtmlTagStripper $htmlTagStripper;

    public function __construct(
        PostRepository $posts,
        FileUploader $fileUploader,
        HtmlTagStripper $htmlTagStripper
    ) {
        $this->posts = $posts;
        $this->fileUploader = $fileUploader;
        $this->htmlTagStripper = $htmlTagStripper;
    }

    public function __invoke(CreatePostCommand $command): void
    {
        $image = $command->image();

        $imagePath = $image->isUploadedFile() ?
            $this->fileUploader->upload($image->file()) :
            $this->fileUploader->uploadFromUrl($image->file());

        $this->posts->add(
            new Post(
                PostId::fromString(Uuid::uuid4()->toString()),
                Title::fromString($command->title()),
                Content::fromString($this->htmlTagStripper->stripeTags($command->content())),
                Image::fromPath($imagePath)
            )
        );
    }
}