<?php

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpKernel\Event\RequestEvent;

class PutMiltipartFormRequestListener implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            RequestEvent::class => 'onKernelRequest',
        ];
    }

    /**
     * @param RequestEvent $event
     */
    public function onKernelRequest(RequestEvent $event): void
    {
        $request = $event->getRequest();

        if ($request->getMethod() !== 'PUT') {
            return;
        }

        if (!preg_match('/multipart\/form-data/', $request->headers->get('Content-Type'))) {
            return;
        }

        $content = $request->getContent();

        if (!$content) {
            return;
        }

        $parameters = $this->decode($content);

        $request->request->replace($parameters['inputs']);
        $request->files->replace($parameters['files']);
    }

    public function decode(string $rawData): array
    {
        $files = [];
        $data = [];

        $boundary = substr($rawData, 0, strpos($rawData, "\r\n"));

        $parts = $rawData ? array_slice(explode($boundary, $rawData), 1) : [];
        foreach ($parts as $part) {
            if ($part === "--\r\n") {
                break;
            }

            $part = ltrim($part, "\r\n");
            [$rawHeaders, $content] = explode("\r\n\r\n", $part, 2);
            $content = substr($content, 0, -2);

            $rawHeaders = explode("\r\n", $rawHeaders);
            $headers = [];
            foreach ($rawHeaders as $header) {
                [$name, $value] = explode(':', $header);
                $headers[strtolower($name)] = ltrim($value, ' ');
            }

            if (isset($headers['content-disposition'])) {
                $filename = null;
                preg_match(
                    '/^form-data; *name="([^"]+)"(; *filename="([^"]+)")?/',
                    $headers['content-disposition'],
                    $matches
                );
                $fieldName = $matches[1];
                $fileName = $matches[3] ?? null;

                if ($fileName !== null) {
                    $localFileName = tempnam(sys_get_temp_dir(), 'sfy');
                    file_put_contents($localFileName, $content);
                    $files = $this->transformData($files, $fieldName, [
                        'name' => $fileName,
                        'type' => $headers['content-type'],
                        'tmp_name' => $localFileName,
                        'error' => 0,
                        'size' => filesize($localFileName)
                    ]);

                    register_shutdown_function(static function () use ($localFileName) {
                        unlink($localFileName);
                    });
                } else {
                    $data = $this->transformData($data, $fieldName, $content);
                }
            }
        }
        $fields = new ParameterBag($data);

        return ['inputs' => $fields->all(), 'files' => $files];
    }

    private function transformData($data, $name, $value)
    {
        $isArray = strpos($name, '[]');
        if ($isArray && (($isArray + 2) === strlen($name))) {
            $name = str_replace('[]', '', $name);
            $data[$name][] = $value;
        } else {
            $data[$name] = $value;
        }
        return $data;
    }
}