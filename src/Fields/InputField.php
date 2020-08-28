<?php


namespace Formy\Fields;


use Formy\Contracts\AbstractField;
use Formy\Helpers\ArrayHelper;
use Illuminate\View\View;

class InputField extends AbstractField
{

    /** @var string  */
    protected $type = 'text';

    /** @var string[]  */
    protected $classes = [];

    /** @var string */
    protected $value = null;

    /** @var string */
    protected $placeholder = null;

    /** @var string */
    protected $label = null;

    /** @var array  */
    protected $options = [];

    public function __construct($name)
    {
        parent::__construct($name);

        $this->options = $this->getDefaultOptions();
        $this->init();
    }

    public function render(): View
    {
        return view('formy::field.input')
            ->with('type', $this->type)
            ->with('classes', $this->classes)
            ->with('value', $this->value)
            ->with('placeholder', $this->placeholder)
            ->with('label', $this->label)
            ->with('formName', $this->getFormName())
            ->with('name', $this->getField())
            ->with('options', $this->options)
            ->with('path', $this->getPath())
        ;
    }

    public function handle(array $request, $target)
    {
        $value = $this->getValueFromRequest($request);
        $fieldName = $this->getField();

        if (is_array($target)) {
            $target[$fieldName] = $value;
        } else {
            $target->{$fieldName} = $value;
        }

        return $target;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     * @return InputField
     */
    public function setType(string $type): InputField
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return string[]
     */
    public function getClasses(): array
    {
        return $this->classes;
    }

    /**
     * @param string[] $classes
     * @return InputField
     */
    public function setClasses(array $classes): InputField
    {
        $this->classes = $classes;
        return $this;
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * @param string $value
     * @return InputField
     */
    public function setValue(string $value): InputField
    {
        $this->value = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getPlaceholder(): string
    {
        return $this->placeholder;
    }

    /**
     * @param string $placeholder
     * @return InputField
     */
    public function setPlaceholder(string $placeholder): InputField
    {
        $this->placeholder = $placeholder;
        return $this;
    }

    /**
     * @return string
     */
    public function getLabel(): string
    {
        return $this->label;
    }

    /**
     * @param string $label
     * @return InputField
     */
    public function setLabel(string $label): InputField
    {
        $this->label = $label;
        return $this;
    }

    protected function init()
    {
        /// empty
    }

    public function getDefaultOptions()
    {
        return [  ];
    }

    /**
     * @param array $options
     * @return InputField
     */
    public function setOptions(array $options): InputField
    {
        $defaultOptions = $this->getDefaultOptions();
        $defaultOptions = ArrayHelper::merge($options, $defaultOptions);

        $this->options = $defaultOptions;
        return $this;
    }

}
