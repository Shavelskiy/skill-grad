<?php

namespace App\Service;

use App\Entity\Upload;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class UploadService implements UploadServiceInterface
{
    protected EntityManagerInterface $em;
    protected string $uploadDir;

    public function __construct(EntityManagerInterface $em, ParameterBagInterface $parameters)
    {
        $this->em = $em;
        $this->uploadDir = $parameters->get('upload_dir');
    }

    public function deleteUpload(Upload $upload): void
    {
        $fileName = $this->uploadDir . '/' . $upload->getName();

        if (file_exists($fileName)) {
            unlink($fileName);
        }

        $this->em->remove($upload);
        $this->em->flush();
    }
}