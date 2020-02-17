<?php

/*
 * This file is part of Flarum.
 *
 * For detailed copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */

namespace Flarum\Install\Prerequisite;

use Illuminate\Support\Collection;

class ForbiddenPaths implements PrerequisiteInterface
{
    protected $paths;

    public function __construct(array $paths)
    {
        $this->paths = $paths;
    }

    public function problems(): Collection
    {
        return (new Collection($this->paths))
            ->reject(function ($path) {
                return ! in_array($this->getPathStatus($path), [200, 301, 302]);
            })->map(function ($path) {
                $status = $this->getPathStatus($path);
                return [
                    'message' => "The path '$path' is accessible via the internet. This is a critical security issue, please adjust your server configuration and reload the page. Status: $status. Test.",
                ];
            });
    }

    private function getPathStatus($path)
    {
        $url  = $path;
        $curlHandle = curl_init();
        curl_setopt($curlHandle, CURLOPT_URL, $url);
        curl_setopt($curlHandle, CURLOPT_HEADER, true);
        curl_setopt($curlHandle, CURLOPT_NOBODY, true);  // we don't need body
        curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, true);
        curl_exec($curlHandle);
        $response = curl_getinfo($curlHandle, CURLINFO_HTTP_CODE);
        curl_close($curlHandle);
        return $response;
    }
}
