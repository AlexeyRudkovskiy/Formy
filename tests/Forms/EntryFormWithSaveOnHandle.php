<?php


namespace Formy\Tests\Forms;


use Formy\Contracts\AbstractForm;
use Formy\Contracts\FormBuilderContract;
use Formy\Contracts\SaveOnHandle;
use Formy\Fields\TextField;
use Formy\Tests\Classes\SimpleObject;

class EntryFormWithSaveOnHandle extends AbstractForm implements SaveOnHandle
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
