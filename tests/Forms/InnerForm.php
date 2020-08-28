<?php


namespace Formy\Tests\Forms;


use Formy\Contracts\AbstractForm;
use Formy\Contracts\FormBuilderContract;
use Formy\Fields\TextField;

class InnerForm extends AbstractForm
{

    public function buildForm(FormBuilderContract $builder): FormBuilderContract
    {
        return $builder
            ->add(new TextField('fieldName'))
        ;
    }

    public function getId(): string
    {
        return 'inner';
    }

}
