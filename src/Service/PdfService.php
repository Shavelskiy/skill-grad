<?php

namespace App\Service;

use Exception;
use RuntimeException;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Process\Process;

class PdfService
{
    protected const PDF_TMP_DIR_PARAM_KEY = 'pdf_tmp_dir';
    protected const FILES_DIR_PARAM_KEY = 'files_dir';

    protected const PDF_GENERATE_COMMAND = '/usr/bin/wkhtmltopdf';

    protected string $pdfTmpDir;
    protected string $documentRootDir;

    public function __construct(
        ParameterBagInterface $params
    ) {
        $this->pdfTmpDir = $params->get(self::PDF_TMP_DIR_PARAM_KEY);
        $this->documentRootDir = $params->get(self::FILES_DIR_PARAM_KEY);
    }

    public function generate($input, $output): void
    {
        if (!is_dir($this->pdfTmpDir)) {
            mkdir($this->pdfTmpDir, 0777);
        }

        $tmpFileName = $this->pdfTmpDir . sprintf('/pdf_tmp_%s.html', time());

        $fileDirection = sprintf('%s/replenish/%s', $this->documentRootDir, $output);

        $this->createDir($fileDirection);

        $outputFilePath = sprintf('%s/%s', $this->documentRootDir, $output);

        $command = sprintf('%s %s %s', self::PDF_GENERATE_COMMAND, $tmpFileName, $outputFilePath);

        try {
            file_put_contents($tmpFileName, $input);

            $process = Process::fromShellCommandline($command);
            $process->run();

            unlink($tmpFileName);
        } catch (Exception $e) {
            throw $e;
        }
    }

    protected function createDir(string $dir): void
    {
        $absoluteDirPath = sprintf('%s/%s', $this->documentRootDir, $dir);

        if (!is_dir($absoluteDirPath) && !mkdir($absoluteDirPath, 0775, true) && !is_dir($absoluteDirPath)) {
            throw new RuntimeException(sprintf('Directory "%s" was not created', $absoluteDirPath));
        }
    }
}
