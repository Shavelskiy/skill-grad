<?php

namespace App\EventSubscriber;

use Exception;
use RuntimeException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\RequestEvent;

class MultipartJsonListener implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            RequestEvent::class => 'onKernelRequest',
        ];
    }

    public function onKernelRequest(RequestEvent $event): void
    {
        $request = $event->getRequest();

        try {
            if ($request->getMethod() !== 'PUT') {
                throw new RuntimeException('');
            }

            if (!preg_match('/multipart\/form-data/', $request->headers->get('Content-Type'))) {
                throw new RuntimeException('');
            }

            $content = $request->getContent();

            if (!$content) {
                throw new RuntimeException('');
            }

            $parameters = $this->decode($content);

            $request->request->replace($parameters['inputs']);
            $request->files->replace($parameters['files']);
        } catch (Exception $e) {
        }

        $this->parseJsonBody($event);
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
                        'size' => filesize($localFileName),
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

    protected function transformData($data, $name, $value)
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

    public function parseJsonBody(RequestEvent $event): void
    {
        $request = $event->getRequest();

        if (!$this->isMultipartRequest($request)) {
            return;
        }

        $content = $request->get('json_content');

        if (empty($content)) {
            return;
        }

        if (!$this->transformJsonBody($request, $content)) {
            $event->setResponse(new Response('Unable to parse request.', 400));
        }
    }

    protected function isMultipartRequest(Request $request): bool
    {
        return strpos($request->headers->get('content-type'), 'multipart/form-data;') === 0;
    }

    protected function transformJsonBody(Request $request, string $content): bool
    {
        $data = json_decode($content, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            return false;
        }

        if ($data === null) {
            return true;
        }

        $request->request->replace($data);

        return true;
    }
}
