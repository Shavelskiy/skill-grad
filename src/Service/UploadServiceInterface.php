<?php

namespace App\Service;

use App\Entity\Upload;
use Symfony\Component\HttpFoundation\File\UploadedFile;

interface UploadServiceInterface
{
    public function createTestUpload(UploadedFile $uploadedFile): UploadedFile;

    public function createUpload(UploadedFile $uploadedFile): Upload;

    public function deleteUpload(Upload $upload): void;
}
