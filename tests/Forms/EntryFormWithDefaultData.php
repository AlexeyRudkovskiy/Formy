<?php


namespace Formy\Tests\Forms;


use Formy\Contracts\AbstractForm;
use Formy\Contracts\FormBuilderContract;
use Formy\Fields\TextField;
use Formy\Tests\Classes\SimpleObject;

class EntryFormWithDefaultData extends AbstractForm
{

    public function buildForm(FormBuilderContract $builder): FormBuilderContract
    {
        return $builder
            ->add(new TextField('title'));
    }

    public function getDefaultClass(): ?string
    {
        return SimpleObject::class;
    }

    public function getId(): string
    {
        return 'entry';
    }

}
