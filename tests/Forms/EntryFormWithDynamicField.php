<?php


namespace Formy\Tests\Forms;


use Formy\Contracts\AbstractForm;
use Formy\Contracts\FormBuilderContract;

class EntryFormWithDynamicField extends AbstractForm
{

    /** @var string */
    protected $fieldType = null;

    public function buildForm(FormBuilderContract $builder): FormBuilderContract
    {
        return $builder
            ->add(function () {
                $fieldType = $this->fieldType;
                return (new $fieldType('input'));
            });
    }

    /**
     * @param string $fieldType
     * @return EntryFormWithDynamicField
     */
    public function setFieldType(string $fieldType): EntryFormWithDynamicField
    {
        $this->fieldType = $fieldType;
        return $this;
    }

    public function getId(): string
    {
        return 'entry';
    }

}
