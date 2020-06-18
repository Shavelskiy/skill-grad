<?php

namespace App\Service;

use App\Entity\Upload;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use RuntimeException;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class UploadService implements UploadServiceInterface
{
    protected EntityManagerInterface $em;
    protected string $uploadDir;

    public function __construct(EntityManagerInterface $em, ParameterBagInterface $parameters)
    {
        $this->em = $em;
        $this->uploadDir = $parameters->get('upload_dir');
    }

    public function createTestUpload(UploadedFile $uploadedFile): UploadedFile
    {
        return new UploadedFile(
            $uploadedFile->getPathname(),
            $uploadedFile->getClientOriginalName(),
            $uploadedFile->getMimeType(),
            $uploadedFile->getError(),
            true
        );
    }

    public function createUpload(UploadedFile $uploadedFile): Upload
    {
        $fileName = uniqid('', true) . '-' . time() . '.' . $uploadedFile->guessExtension();

        try {
            $uploadedFile->move($this->uploadDir, $fileName);
        } catch (Exception $e) {
            throw new RuntimeException('Ошибка при сохранении файла');
        }

        return (new Upload())->setName($fileName);
    }


    public function deleteUpload(Upload $upload): void
    {
        $fileName = $this->uploadDir . '/' . $upload->getName();

        if (file_exists($fileName)) {
            unlink($fileName);
        }

        $this->em->remove($upload);
    }
}