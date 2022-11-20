<?php

namespace Modules\Init\Traits;

use Modules\Init\Supports\Helper;

trait LoadAndPublishDataTrait
{
    protected $namespace = null;

    protected $basePath = null;

    public function setNameSpace(string $namespace): self
    {
        $this->namespace = ltrim(rtrim($namespace, '/'), '/');
        return $this;
    }

    public function getBasePath(): string
    {
        return $this->basePath ?? base_path('Modules');
    }

    public function setBasePath($path): self
    {
        $this->basePath = $path;
        return $this;
    }

    /**
     * @return string
     */
    protected function getDashedNamespace(): string
    {
        return str_replace('.', '/', $this->namespace);
    }

    /**
     * @return string
     */
    protected function getDotedNamespace(): string
    {
        return str_replace('/', '.', $this->namespace);
    }

    public function loadHelpers(): self
    {
        Helper::autoload(base_path('Modules/') . $this->getDashedNamespace() . '/Helpers');
        return $this;
    }
}