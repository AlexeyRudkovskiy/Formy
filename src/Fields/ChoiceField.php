<?php


namespace Formy\Fields;


use Formy\Contracts\AbstractField;
use Formy\Contracts\SometimesHandleAfterSave;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\View\View;

class ChoiceField extends AbstractField implements SometimesHandleAfterSave
{

    /** @var array */
    protected $items = [];

    /** @var callable */
    protected $itemsResolver = null;

    /** @var string */
    protected $relatedModel = null;

    /** @var string */
    protected $valueField = null;

    /** @var string */
    protected $idField = null;

    /** @var string */
    protected $childsField = null;

    /** @var callable */
    protected $valueResolver = null;

    /** @var callable */
    protected $idResolver = null;

    /** @var bool  */
    protected $isMultiple = false;

    /** @var bool  */
    protected $isExpanded = false;

    /** @var bool  */
    protected $useSyncToSave = false;

    public function render(): View
    {
        $items = $this->itemsResolver !== null
            ? call_user_func($this->itemsResolver, $this)
            : $this->items;

        $this->build();
        $idResolver = $this->idResolver;

        $selectedItems = null;
        if ($this->getValue() instanceof Collection) {
            $selectedItems = $this->getValue();
        } else {
            $selectedItems = $this->isMultiple ? ($this->getValue() ?? []) : [$this->getValue() ?? []];
            $selectedItems = collect($selectedItems);
        }
        $selectedItems = $selectedItems
            ->map(function ($item) use ($idResolver) {
                return $idResolver($item);
            })
            ->toArray();

        $targetView = $this->isExpanded
            ? view('formy::field.choice_inputs')
            : view('formy::field.choice_select');

        return $targetView
            ->with('items', $items)
            ->with('name', $this->getField())
            ->with('formName', $this->getFormName())
            ->with('idResolver', $this->idResolver)
            ->with('valueResolver', $this->valueResolver)
            ->with('multiple', $this->isMultiple)
            ->with('childsField', $this->childsField)
            ->with('selected', $selectedItems)
        ;
    }

    public function handle(array $request, $target)
    {
        $value = $this->getValueFromRequest($request);
        $fieldName = $this->getField();

        $this->build();
        if ($this->relatedModel !== null && !$this->useSyncToSave) {
            $value = call_user_func([ $this->relatedModel, 'find' ], $value);
        }

        $this->value = $value;

        if ($this->shouldHandleAfterSave()) {
            if ($this->useSyncToSave) {
                $target->{$fieldName}()->sync($value);
            } else {
                if (!$this->isMultiple) {
                    if ($target instanceof Model) {
                        $relationshipObject = $target->{$fieldName}();
                        if (method_exists($relationshipObject, 'save')) {
                            $relationshipObject->save($value);
                            $value->save();
                        } else if (method_exists($relationshipObject, 'associate')) {
                            $relationshipObject->associate($value);
                        } else {
                            /// todo: throw an exception
                        }
                    } else if (is_array($target)) {
                        $target[$fieldName] = $value;
                    }
                } else {
                    if ($target instanceof Model) {
                        $value->each(function (Model $record) use ($target, $fieldName) {
                            $target->{$fieldName}()->save($record);
                        });
                    } else {
                        $target[$fieldName] = $value;
                    }
                }
            }
        } else {
            if (is_array($target)) {
                $target[$fieldName] = $value;
            } else {
                $target->{$fieldName} = $value;
            }
        }

        return $target;
    }

    /**
     * @return array
     */
    public function getItems(): array
    {
        return $this->items;
    }

    /**
     * @param array $items
     * @return ChoiceField
     */
    public function setItems(array $items): ChoiceField
    {
        $this->items = $items;
        return $this;
    }

    /**
     * @return callable
     */
    public function getItemsResolver(): callable
    {
        return $this->itemsResolver;
    }

    /**
     * @param callable $itemsResolver
     * @return ChoiceField
     */
    public function setItemsResolver(callable $itemsResolver): ChoiceField
    {
        $this->itemsResolver = $itemsResolver;
        return $this;
    }

    /**
     * @return string
     */
    public function getRelatedModel(): string
    {
        return $this->relatedModel;
    }

    /**
     * @param string $relatedModel
     * @return ChoiceField
     */
    public function setRelatedModel(string $relatedModel): ChoiceField
    {
        $this->relatedModel = $relatedModel;
        return $this;
    }

    /**
     * @return string
     */
    public function getValueField(): string
    {
        return $this->valueField;
    }

    /**
     * @param string $valueField
     * @return ChoiceField
     */
    public function setValueField(string $valueField): ChoiceField
    {
        $this->valueField = $valueField;
        return $this;
    }

    /**
     * @return string
     */
    public function getIdField(): string
    {
        return $this->idField;
    }

    /**
     * @param string $idField
     * @return ChoiceField
     */
    public function setIdField(string $idField): ChoiceField
    {
        $this->idField = $idField;
        return $this;
    }

    /**
     * @return string
     */
    public function getChildsField(): string
    {
        return $this->childsField;
    }

    /**
     * @param string $childsField
     * @return ChoiceField
     */
    public function setChildsField(string $childsField): ChoiceField
    {
        $this->childsField = $childsField;
        return $this;
    }

    /**
     * @return bool
     */
    public function isMultiple(): bool
    {
        return $this->isMultiple;
    }

    /**
     * @param bool $isMultiple
     * @return ChoiceField
     */
    public function setIsMultiple(bool $isMultiple): ChoiceField
    {
        $this->isMultiple = $isMultiple;
        return $this;
    }

    /**
     * @return bool
     */
    public function isExpanded(): bool
    {
        return $this->isExpanded;
    }

    /**
     * @param bool $isExpanded
     * @return ChoiceField
     */
    public function setIsExpanded(bool $isExpanded): ChoiceField
    {
        $this->isExpanded = $isExpanded;
        return $this;
    }

    /**
     * @return bool
     */
    public function isUseSyncToSave(): bool
    {
        return $this->useSyncToSave;
    }

    /**
     * @param bool $useSyncToSave
     * @return ChoiceField
     */
    public function setUseSyncToSave(bool $useSyncToSave): ChoiceField
    {
        $this->useSyncToSave = $useSyncToSave;
        return $this;
    }

    protected function build()
    {
        $resolver = function ($field) {
            $field = $field . 'Field';
            return function ($item) use ($field) {
                if (empty($item) || $item === null) {
                    return null;
                }
                return is_array($item) ? $item[$this->{$field}] : $item->{$this->{$field}};
            };
        };

        if ($this->idResolver === null) {
            $this->idResolver = $resolver('id');
        }

        if ($this->valueResolver === null) {
            $this->valueResolver = $resolver('value');
        }
    }

    public function shouldHandleAfterSave(): bool
    {
        $value = $this->getValue();
        return $this->relatedModel !== null && (
            $value instanceof Model
            || $value instanceof \Illuminate\Database\Eloquent\Collection
        );
    }

}
