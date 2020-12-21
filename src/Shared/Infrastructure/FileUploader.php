<?php

namespace App\Shared\Infrastructure;

use Symfony\Component\HttpFoundation\File\UploadedFile;

interface FileUploader
{
    public function upload(UploadedFile $file): string;

    public function uploadFromUrl(string $url): string;
}