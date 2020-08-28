<?php


namespace Formy\Contracts;


use App\Admin\Forms\ContactForm;
use Formy\Fields\CollectionField;
use Formy\Fields\OneToManyRelationshipField;
use Formy\Fields\RelationshipField;
use Formy\Traits\WithLevel;
use Formy\Traits\WithPrefix;
use Illuminate\Database\Eloquent\Model;

abstract class AbstractFormBuilder implements FormBuilderContract
{

    /** @var array */
    protected $fields = [];

    /** @var FormContract[] */
    protected $childForms = [];

    /** @var FieldContract[] */
    protected $childFields = [];

    /** @var int  */
    protected $level = 0;

    /** @var Model|\stdClass|array */
    protected $target;

    /** @var FormContract */
    protected $form = null;

    /** @var array  */
    protected $mappings = [];

    /**
     * @inheritDoc
     */
    public function add($child, $name = null): FormBuilderContract
    {
        $mapName = null;

        /// todo: need to refactor this method
        if ($child instanceof FormContract) {
            $formName = $name ?? $child->getId();
            $mapName = $formName;

            $this->mapChild($child, $formName);
            $child->prepare($this->target);

            $currentPath = $this->getCurrentPath();

            array_push($currentPath, $formName);
            array_push($this->childForms, $child);

            $child->setPath($currentPath);
        } else if ($child instanceof FieldContract) {
            $currentPath = $this->getCurrentPath();
            array_push($currentPath, $child->getField());

            $child->prepare($this->target);
            $child->setFormName($this->getFormPrefixOrId());
            $child->setPath($currentPath);

            $mapName = $child->getField();

            array_push($this->childFields, $child);
        } else if (is_callable($child)) {
            $child = call_user_func($child);

            return $this->add($child, $name);
        } else {
            $child = app()->make($child);

            return $this->add($child, $name);
        }

        $traits = $this->getTraits(get_class($child));

        if (in_array(WithLevel::class, $traits)) {
            $child->setLevel($this->level + 1);
        }

        if (in_array(WithPrefix::class, $traits)) {
//            $childPrefix = $this->getForm()->getId() . '[' . $child->getField() . ']';
            $childName = $name ?? ($child instanceof FieldContract ? $child->getField() : $child->getId());
            $childPrefix = $this->getChildPrefix($childName);
            $child->setPrefix($childPrefix);
        }

        array_push($this->fields, $child);
        $this->mappings[$mapName] = $child;

        return $this;
    }

    public function getChildForms(): array
    {
        return $this->childForms;
    }

    public function getFields(): array
    {
        return $this->fields;
    }

    public function setLevel(int $level): FormBuilderContract
    {
        $this->level = $level;

        return $this;
    }

    public function setTarget($target): FormBuilderContract
    {
        $this->target = $target;

        return $this;
    }

    public function setForm(FormContract $form): FormBuilderContract
    {
        $this->form = $form;
        return $this;
    }

    public function getForm(): FormContract
    {
        return $this->form;
    }


    public function build()
    {

    }

    protected function getChildPrefix($fieldName)
    {
        $prefix = $this->getFormPrefixOrId();

        return $prefix . '[' . $fieldName . ']';
    }

    /**
     * @param FieldContract|FormContract $child
     * @param string $name
     */
    public function mapChild($child, string $name)
    {
        if (!array_key_exists($name, $this->mappings)) {
            $this->mappings[$name] = $child;
            return $name;
        } else {
            throw new \Exception("Can't add two fields with the same name");
        }
    }

    public function getFormPrefixOrId()
    {
        $currentForm = $this->getForm();
        return $currentForm->getPrefix() ?? $currentForm->getId();
    }

    public function getCurrentPath(): array
    {
        $currentForm = $this->getForm();
        return $currentForm->getPath();
    }

    /**
     * @todo need to move this method to separated class
     *
     * @param $class
     * @param bool $autoload
     * @return array
     */
    function getTraits($class, $autoload = true) {
        $traits = [];
        do {
            $traits = array_merge(class_uses($class, $autoload), $traits);
        } while($class = get_parent_class($class));
        foreach ($traits as $trait => $same) {
            $traits = array_merge(class_uses($trait, $autoload), $traits);
        }
        return array_unique($traits);
    }


}
