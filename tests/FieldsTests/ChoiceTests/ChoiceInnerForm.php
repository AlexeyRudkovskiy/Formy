<?php


namespace Formy\Tests\FieldsTests\ChoiceTests;


use Formy\Contracts\AbstractForm;
use Formy\Contracts\FormBuilderContract;
use Formy\Contracts\HandleAfterSave;
use Formy\Fields\TextField;

class ChoiceInnerForm extends AbstractForm implements HandleAfterSave
{

    public function buildForm(FormBuilderContract $builder): FormBuilderContract
    {
        return $builder
            ->add(new TextField('name'))
        ;
    }

    public function getId(): string
    {
        return 'tail';
    }

}
