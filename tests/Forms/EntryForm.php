<?php


namespace Formy\Tests\Forms;


use Formy\Contracts\AbstractForm;
use Formy\Contracts\FormBuilderContract;
use Formy\Fields\TextField;

class EntryForm extends AbstractForm
{

    public function buildForm(FormBuilderContract $builder): FormBuilderContract
    {
        return $builder
            ->add(new TextField('title'));
    }

    public function getId(): string
    {
        return 'entry';
    }

}
