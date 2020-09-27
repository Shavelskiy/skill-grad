<?php

namespace App\Messenger;

use Symfony\Component\Process\Process;

class Pdf
{
    private string $binary;

    public function __construct($binary)
    {
        $this->binary = $binary;
    }

    public function generate($input, $output): void
    {
        $fileName = __DIR__ . '/../../kek.html';

        $command = $this->binary . ' ' . escapeshellarg($input) . ' ' . escapeshellarg($output);

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
