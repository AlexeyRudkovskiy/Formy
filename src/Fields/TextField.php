<?php


namespace Formy\Fields;


use Formy\Contracts\AbstractField;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TextField extends InputField
{

    protected function init()
    {
        $this
            ->setType('text')
            ->setLabel($this->getField())
            ->setPlaceholder($this->getField())
        ;
    }


}
