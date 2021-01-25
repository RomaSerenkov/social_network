<?php
namespace App\Service;

use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileUploader
{
    private $targetDir;

    public function __construct($targetDir)
    {
        $this->targetDir = $targetDir;
    }

    public function upload(string $path, UploadedFile $file): string
    {
        $fileName = $this->generateUniqueFileName() . '.' . $file->guessExtension();

        try {
            $file->move($this->getTargetDir() . $path, $fileName);
        } catch (FileException $e) {
            throw new FileException('Failed to upload file');
        }

        return $fileName;
    }

    public function delete(string $path): bool
    {
        $filePath = $this->getTargetDir() . $path;
        if (file_exists($filePath)) {
            unlink($filePath);

            return true;
        }

        return false;
    }

    public function getTargetDir()
    {
        return $this->targetDir;
    }

    /**
     * @return string
     */
    private function generateUniqueFileName(): string
    {
        return md5(uniqid());
    }
}
