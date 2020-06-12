<?php

namespace App\Service;

use App\Entity\Upload;

interface UploadServiceInterface
{
    public function deleteUpload(Upload $upload): void;
}
