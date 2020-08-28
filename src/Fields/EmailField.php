<?php


namespace Formy\Fields;


use Formy\Contracts\AbstractField;

class EmailField extends InputField
{

    public function __construct(string $name)
    {
        parent::__construct($name);

        $this
            ->setType('email')
            ->setLabel($name)
            ->setPlaceholder($name)
            ->setValue('testing')
        ;
    }

}
