<?php


namespace Formy\Tests\Forms;


use Formy\Contracts\AbstractForm;
use Formy\Contracts\FormBuilderContract;
use Formy\Contracts\HandleAfterSave;
use Formy\Fields\TextField;

class UnicornTailForm extends AbstractForm implements HandleAfterSave
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