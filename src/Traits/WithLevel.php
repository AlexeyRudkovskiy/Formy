<?php


namespace Formy\Traits;


trait WithLevel
{

    /** @var int  */
    protected $level = 1;

    public function getLevel(): int
    {
        return $this->level;
    }

    public function setLevel(int $level)
    {
        $this->level = $level;
    }

}
