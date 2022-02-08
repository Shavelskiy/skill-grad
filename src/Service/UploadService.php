<?php

namespace App\Service;

use App\Entity\Upload;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Ramsey\Uuid\Uuid;
use RuntimeException;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class UploadService implements UploadServiceInterface
{
    protected EntityManagerInterface $entityManager;
    protected string $uploadDir;

    public function __construct(
        EntityManagerInterface $entityManager,
        ParameterBagInterface $parameters
    ) {
        $this->entityManager = $entityManager;
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
        $uuid = Uuid::uuid4();

        $fileName = $uuid->toString() . '-' . time() . '.' . $uploadedFile->guessExtension();
        $filePath = $this->getFilePath($fileName);

        try {
            if (!is_dir($filePath)) {
                mkdir($filePath, 0777, true);
            }
            $uploadedFile->move($filePath, $fileName);
        } catch (Exception $e) {
            throw new RuntimeException('Ошибка при сохранении файла');
        }

        return (new Upload())->setName($fileName);
    }

    public function deleteUpload(Upload $upload): void
    {
        $filePath = $this->getFilePath($upload->getName());
        $fileName = $filePath . '/' . $upload->getName();

        if (file_exists($fileName)) {
            unlink($fileName);
        }

        $this->entityManager->remove($upload);
    }

    protected function getFilePath(string $fileName): string
    {
        [$path1, $path2, $path3] = explode('-', $fileName);

        return sprintf('%s/%s/%s/%s',
            $this->uploadDir,
            substr($path1, 0, 3),
            substr($path2, 0, 3),
            substr($path3, 0, 3)
        );
    }
}
