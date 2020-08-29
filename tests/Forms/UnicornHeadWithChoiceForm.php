<?php


namespace Formy\Tests\Forms;


use Formy\Contracts\AbstractForm;
use Formy\Contracts\FormBuilderContract;
use Formy\Contracts\SaveOnHandle;
use Formy\Fields\ChoiceField;
use Formy\Fields\TextField;
use Formy\Tests\Database\Models\UnicornTail;

class UnicornHeadWithChoiceForm extends AbstractForm implements SaveOnHandle
{

    protected $isMultiple = false;

    public function buildForm(FormBuilderContract $builder): FormBuilderContract
    {
        return $builder
            ->add(new TextField('title'))
            ->add(function () {
                return (new ChoiceField('tail'))
                    ->setItemsResolver(function () { return UnicornTail::all(); })
                    ->setRelatedModel(UnicornTail::class)
                    ->setIdField('id')
                    ->setValueField('name')
                    ->setIsMultiple($this->isMultiple);
            })
        ;
    }

    public function getId(): string
    {
        return 'head';
    }

    /**
     * @param bool $isMultiple
     */
    public function setIsMultiple(bool $isMultiple): void
    {
        $this->isMultiple = $isMultiple;
    }

}