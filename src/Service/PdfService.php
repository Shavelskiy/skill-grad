<?php

namespace App\Service;

use Symfony\Component\Process\Process;

class PdfService
{
    public function generate($input, $output, string $binary): void
    {
        $fileName = __DIR__ . '/../../kek.html';

        $command = $binary . ' ' . escapeshellarg($input) . ' ' . escapeshellarg($output);

        try {
            file_put_contents($fileName, $input);

            $process = Process::fromShellCommandline($command);
            $process->run();

            unlink($fileName);
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
