<?php


namespace Formy\Contracts;


use Illuminate\Database\Eloquent\Model;

interface FormBuilderContract
{

    /**
     * @param FieldContract|FormContract|string $child
     * @param string $name
     * @return mixed
     */
    public function add($child, $name = null): FormBuilderContract;

    /**
     * @return FormContract[]
     */
    public function getChildForms(): array;

    /**
     * @return array
     */
    public function getFields(): array;

    /**
     * @param int $level
     * @return FormBuilderContract
     */
    public function setLevel(int $level): FormBuilderContract;

    /**
     * @param Model|\stdClass|array $target
     * @return mixed
     */
    public function setTarget($target): FormBuilderContract;

    /**
     * @param FormContract $form
     * @return FormBuilderContract
     */
    public function setForm(FormContract $form): FormBuilderContract;

    /**
     * @return FormContract
     */
    public function getForm(): FormContract;

    /**
     * @return mixed
     */
    public function build();

}
