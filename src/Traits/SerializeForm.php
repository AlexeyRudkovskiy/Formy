<?php


namespace Formy\Traits;


use Formy\Contracts\FormBuilderContract;

trait SerializeForm
{

    public function toArray()
    {
        $this->build();
        /** @var FormBuilderContract $formBuilder */
        $formBuilder = $this->formBuilder;
        $fields = $formBuilder->getFields();

        $result = [];
        foreach ($fields as $field) {
            array_push($result, $field->toArray());
        }

        return $result;
    }

}
