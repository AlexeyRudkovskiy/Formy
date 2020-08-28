<?php


namespace Formy\Fields;


use Formy\Contracts\AbstractField;
use Illuminate\View\View;

class NumberField extends InputField
{

    protected function init()
    {
        $this
            ->setType('number')
            ->setLabel($this->getField())
            ->setPlaceholder($this->getField())
            ->setValue('testing')
        ;
    }

    public function getDefaultOptions()
    {
        return [
            'step' => 1,
            'attributes' => [
                'class' => 'so-simple'
            ]
        ];
    }

}
