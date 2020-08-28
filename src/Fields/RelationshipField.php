<?php


namespace Formy\Fields;


use Formy\Contracts\AbstractField;
use Formy\Contracts\HandleAfterSave;
use Formy\Traits\WithLevel;
use Illuminate\Database\Eloquent\Model;

abstract class RelationshipField extends AbstractField implements HandleAfterSave
{

    use WithLevel;

    /** @var string */
    protected $form = null;

    /** @var string */
    protected $objectClass;

    /** @var string[]  */
    protected $prefix = [];

    public function __construct($field, string $form)
    {
        parent::__construct($field);

        $this->form = $form;
    }

    /**
     * @return Model|array
     */
    protected function getDefaultValue()
    {
        $object = $this->getDefaultClass();
        if ($object !== null) {
            $object = new $object;
            return $object;
        }

        return [];
    }

    protected function getDefaultClass(): ?string
    {
        return $this->objectClass;
    }

    /**
     * @param string $objectClass
     * @return RelationshipField
     */
    public function setObjectClass(string $objectClass): RelationshipField
    {
        $this->objectClass = $objectClass;
        return $this;
    }

}
