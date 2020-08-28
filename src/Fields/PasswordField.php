<?php


namespace Formy\Fields;


use Formy\Contracts\AbstractField;

class PasswordField extends InputField
{

    public function __construct(string $name)
    {
        parent::__construct($name);

        $this
            ->setType('password')
            ->setLabel($name)
            ->setPlaceholder($name)
            ->setValue('testing')
        ;
    }

}
