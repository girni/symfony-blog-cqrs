<?php

namespace App\Blog\Infrastructure;

use App\Shared\Infrastructure\FileUploader;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

final class PostImageFileUploader implements FileUploader
{
    private string $directory;

    public function __construct(string $directory)
    {
        $this->directory = $directory;
    }

    public function upload(UploadedFile $file): string
    {
        $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $fileName = time() . '.' . $file->guessExtension();

        try {
            $file->move($this->directory, $fileName);
        } catch (FileException $e) {
            throw new PostImageUploadException('Unable to upload image: ' . $e->getMessage());
        }

        return $fileName;
    }

    /**
     * @param string $url
     * @return string
     */
    public function uploadFromUrl(string $url): string
    {
        $allowedExtensions = ['jpg', 'jpeg'];
        $urlExtension = pathinfo($url,  PATHINFO_EXTENSION);

        if (!in_array($urlExtension, $allowedExtensions, true)) {
            throw new PostImageUploadException('Invalid extension. Only JPEG are allowed.');
        }

        $fileName = time()  . '.jpg';
        $file = file_get_contents($url);
        $newFilePath = $this->directory . '/' . $fileName;

        file_put_contents($newFilePath, $file);

        return $fileName;
    }

}