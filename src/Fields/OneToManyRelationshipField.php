<?php


namespace Formy\Fields;


use Formy\Contracts\FormContract;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OneToManyRelationshipField extends RelationshipField
{

    /** @var FormContract */
    protected $form = null;

    public function __construct($field, string $form)
    {
        parent::__construct($field, $form);
    }

    public function render(): View
    {
        $form = $this->build();
        return $form->render();
    }

    public function handle(array $request, $target)
    {
        $form = $this->build();
        $fieldName = $this->getField();

        $updated = $form->handle($request, $target);

        $target->{$fieldName}()->save($updated);

        return $updated;
    }

    public function prepare($target)
    {
        $this->value = $target->{$this->getField()} ?? $this->getDefaultValue();
    }

    protected function build(): FormContract
    {
        /** @var FormContract $form */
        $form = call_user_func([ $this->form, 'create' ], $this->value, $this->getPrefix());
        $form->setPath($this->getPath());
        $form->setLevel($this->getLevel());

        return $form;
    }

}
