<?php


namespace Formy\Fields;


use Formy\Contracts\AbstractField;
use Formy\Contracts\FormContract;
use Formy\Traits\WithLevel;
use Illuminate\View\View;

class CollectionField extends AbstractField
{

    use WithLevel;

    /** @var string */
    protected $formClass = null;

    public function render(): View
    {
        $items = $this->getValue() ?? [];
        $forms = [];

        foreach ($items as $index => $item) {
            $form = $this->build($item, $index);

            array_push($forms, $form);
        }

        return view('formy::field.collection')
            ->with('forms', $forms)
            ->with('test', function ($index) {
                return $index;
            });
    }

    public function handle(array $request, $target)
    {
        $updatedValues = $this->getValueFromRequest($request);
        $fieldName = $this->getField();

        foreach ($updatedValues as $index => $value) {
            $form = $this->build($value, $index);
            $updatedValues[$index] = $form->handle($request);
        }

        if (is_array($target)) {
            $target[$fieldName] = $updatedValues;
        } else {
            $target->{$fieldName} = $updatedValues;
        }

        return $target;
    }

    /**
     * @return string
     */
    public function getFormClass(): string
    {
        return $this->formClass;
    }

    /**
     * @param string $formClass
     * @return CollectionField
     */
    public function setFormClass(string $formClass): CollectionField
    {
        $this->formClass = $formClass;
        return $this;
    }

    /**
     * @todo: need to move this method to a separated class too
     *
     * @param $item
     * @return mixed
     */
    protected function build($item, $index): FormContract
    {
        $form = call_user_func([ $this->formClass, 'create' ], $this->value[$index] ?? [], $this->getPrefix());

        $currentPrefix = $this->getPrefix() . '[' . $index . ']';
        $currentPath = $this->getPath();
        array_push($currentPath, $index);

        $form->setPrefix($currentPrefix);
        $form->setPath($currentPath);
        $form->setLevel($this->getLevel());

        return $form;
    }

    protected function indexResolver($item, $index)
    {
        return $index;
    }

}
