<?php


namespace Formy\Tests\Forms;


use Formy\Contracts\AbstractForm;
use Formy\Contracts\FormBuilderContract;
use Formy\Fields\TextField;

class EntryFormWithSubform extends AbstractForm
{

    public function buildForm(FormBuilderContract $builder): FormBuilderContract
    {
        return $builder
            ->add(new TextField('title'))
            ->add(InnerForm::class, 'inner')
        ;
    }

    public function getId(): string
    {
        return 'entry';
    }

}
