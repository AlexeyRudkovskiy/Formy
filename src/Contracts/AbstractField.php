<?php


namespace Formy\Contracts;


use Formy\Helpers\ArrayHelper;
use Formy\Traits\WithPath;
use Formy\Traits\WithPrefix;
use Illuminate\Database\Eloquent\Model;

abstract class AbstractField implements FieldContract
{

    use WithPrefix, WithPath;

    protected $name;

    protected $value = null;

    /** @var string */
    protected $formName = null;

    protected $path = [ ];

    /**
     * Errors
     *
     * @var array
     */
    protected $errors = [  ];

    /**
     * AbstractField constructor.
     * @param $name
     */
    public function __construct($name)
    {
        $this->name = $name;
    }

    public function getField(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getFormName(): string
    {
        return $this->formName ?? 'default';
    }

    /**
     * @param string $formName
     * @return AbstractField
     */
    public function setFormName(string $formName): FieldContract
    {
        $this->formName = $formName;
        return $this;
    }

    public function getPath(): array
    {
        return $this->path;
    }

    public function setPath(array $path)
    {
        $this->path = $path;
    }

    public function setErrors(array $errors)
    {
        $this->errors = $errors;
    }

    protected function getViewParameters(): array
    {
        return [
            'field' => $this->getField(),
            'formName' => $this->getFormName(),
            'errors' => $this->errors
        ];
    }

    public function getDefaultParameters(): array
    {
        return [  ];
    }

    public function prepare($target)
    {
        if ($target === null) {
            return ;
        }

        $this->value = $this->getValueFromTarget($target);
    }

    protected function getValueFromTarget($target)
    {
        $fieldName = $this->getField();

        try {
            return $target instanceof Model || $target instanceof \stdClass || is_object($target) ?
                $target->{$fieldName} : $target[$fieldName] ?? '';
        } catch (\Exception $e) {
            dd($e, $target);
        }
    }

    /**
     * @param array $request
     * @return mixed
     */
    protected function getValueFromRequest($request)
    {
        $path = $this->getPath();
        $path = implode('.', $path);

        $value = \Arr::get($request, $path);

        return $value;
    }

    protected function mergeParameters(array $parameters)
    {
        $default = $this->getDefaultParameters();

        $default = ArrayHelper::merge($parameters, $default);
        return $default;
    }

    public function getValue()
    {
        return $this->value;
    }

}
