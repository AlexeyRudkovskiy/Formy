<?php

namespace Formy\Traits;


trait WithPrefix
{

    /** @var ?string  */
    protected $prefix = null;

    public function setPrefix(string $prefix)
    {
        $this->prefix = $prefix;
        return $this;
    }

    public function getPrefix(): ?string
    {
        return $this->prefix;
    }

}
