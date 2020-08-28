<?php

namespace Formy\Traits;


trait WithPath
{

    /** @var string[]  */
    protected $path = [];

    /**
     * @param string[] $path
     * @return $this
     */
    public function setPath(array $path)
    {
        $this->path = $path;
        return $this;
    }

    public function getPath(): array
    {
        return $this->path;
    }

}
