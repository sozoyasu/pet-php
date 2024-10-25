<?php

namespace App\View\Extensions;

use InvalidArgumentException;

class ViteViewExtension
{
    private bool $isProduction;
    private string $viteHost;
    private int $vitePort;
    private bool $viteHttps;
    private array $productionPathReplaces;
    private bool $developmentViteScriptIsIncluded = false;

    public function __construct(bool $isProduction = false, string $viteHost = 'localhost', int $vitePort = 3000, $viteHttps = false, $productionPathReplaces = [])
    {
        $this->isProduction = $isProduction;
        $this->viteHost = $viteHost;
        $this->vitePort = $vitePort;
        $this->viteHttps = $viteHttps;
        $this->productionPathReplaces = $productionPathReplaces;
    }

    public function __invoke(string $path): string
    {
        return $this->asset($path);
    }

    public function asset(string $path): string
    {
        $result = '';

        if (!$this->isProduction) {
            $url  = ($this->viteHttps ? 'https://' : 'http://') . $this->viteHost . ':' . $this->vitePort;

            if (!$this->developmentViteScriptIsIncluded) {
                $result = $this->jsAsset($url . DIRECTORY_SEPARATOR .'@vite/client');
                $this->developmentViteScriptIsIncluded = true;
            }

            $path = $url . DIRECTORY_SEPARATOR . $path;
        } else {
            foreach ($this->productionPathReplaces as $search => $replace) {
                $path = str_replace($search, $replace, $path);
            }

            $path = '/' . $path;
        }

        return $result . PHP_EOL . $this->assetResolve($path);
    }

    private function assetResolve(string $path): string
    {
        if (str_ends_with($path, ".js")) {
            return $this->jsAsset($path);
        }

        if (str_ends_with($path, ".css")) {
            return $this->cssAsset($path);
        }

        throw new InvalidArgumentException('Unsupported asset path: ' . $path);
    }

    private function jsAsset(string $path): string
    {

        return '<script type="module" src="'.$path.'"></script>';
    }

    private function cssAsset(string $path): string
    {
        return '<link rel="stylesheet" href="'.$path.'">';
    }
}