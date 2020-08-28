<?php


namespace Formy\Tests\Classes;


class SimpleObject
{

    public $title;

    /**
     * SimpleObject constructor.
     * @param $title
     */
    public function __construct($title = null)
    {
        $this->title = $title;
    }

}
