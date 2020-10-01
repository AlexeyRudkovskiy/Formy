<?php


namespace Formy\Contracts;


use Formy\Traits\WithLevel;
use Formy\Traits\WithPath;
use Formy\Traits\WithPrefix;
use Illuminate\Database\Eloquent\Model;
use Illuminate\View\View;

abstract class AbstractForm implements FormContract
{

    use WithPrefix, WithPath, WithLevel;

    /** @var FormBuilderContract */
    protected $formBuilder = null;

    /** @var string */
    protected $id;

    /** @var Model|\stdClass|array */
    protected $target;

    /** @var string */
    protected $url;

    protected $isFormAlreadyBuilt = false;

    /**
     * AbstractForm constructor.
     * @param Model|\stdClass|array $target
     * @param string $prefix
     */
    public function __construct($target = null, $prefix = null)
    {
        if ($prefix === null) {
            $id = strtolower(get_called_class());
            $id = str_replace(['/', '\\', '$', '@'], '_', $id);
            $id = 'form_' . $id;
        } else {
            $id = $prefix;
        }

        $this->id = $id;
        $this->target = $target;
        $this->prefix = $prefix;
        $this->path = [ $this->getId() ];
        $this->setLevel(0);
    }

    public function build(): FormBuilderContract
    {
        if ($this->isFormAlreadyBuilt) {
            $this->formBuilder;
        }

        if ($this->target === null) {
            $this->target = $this->getDefaultValue();
        }

        $this->formBuilder = app()->make(FormBuilderContract::class);
        $this->formBuilder
            ->setLevel($this->level + 1)
            ->setTarget($this->target)
            ->setForm($this);

        $this->isFormAlreadyBuilt = true;

        return $this->buildForm($this->formBuilder);
    }

    public function render(): View
    {
        $form = $this->build();
        $path = $this->getPath();
        $path = implode('-', $path);

        return view('formy::layout.debug')
            ->with('form', $form)
            ->with('level', $this->level)
            ->with('id', $this->getId())
            ->with('url', $this->getUrl())
            ->with('cssClass', $path);
    }

    /**
     * @inheritDoc
     */
    public function handle(array $request)
    {
        /** @var FormBuilderContract $form */
        $form = $this->build();
        $fields = $form->getFields();

        /** @var FormContract|FieldContract $field */
        foreach ($fields as $field) {
            $updatedValue = $field->handle($request, $this->target);
            if ($field instanceof HandleAfterSave ||
                $field instanceof IgnoreOnHandle ||
                ($field instanceof SometimesHandleAfterSave && $field->shouldHandleAfterSave())
            ) {
                continue ;
            }

            $this->updateFieldValue($field, $updatedValue);
        }

        if ($this instanceof SaveOnHandle && $this->target instanceof Model) {
            $this->target->save();

            foreach ($fields as $field) {
                $updatedValue = $field->handle($request, $this->target);
                if (!($field instanceof HandleAfterSave ||
                    $field instanceof IgnoreOnHandle ||
                    ($field instanceof SometimesHandleAfterSave && $field->shouldHandleAfterSave())
                )) {
                    continue ;
                }

                $this->updateFieldValue($field, $updatedValue);
            }
        }

        return $this->target;
    }

    public function prepare($target)
    {
        $this->target = $this->getValueFromTarget($target);
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id)
    {
        echo $id;
        $this->id = $id;
    }

    /**
     * @param Model|\stdClass|array $target
     * @param string|null $prefix
     */
    public static function create($target = null, string $prefix = null)
    {
//        if (get_called_class() === SuperForm::class) {
//            dd(1);
//        }
        /** @var FormContract $form */
        $form = app()->make(get_called_class(), [ 'target' => $target, 'prefix' => $prefix ]);
        $form->setLevel(0);

        return $form;
    }

    public function getDefaultValue()
    {
        if ($this->getDefaultClass() !== null) {
            $object = $this->getDefaultClass();
            $object = new $object;

            return $object;
        }

        return [];
    }

    public function getDefaultClass(): ?string
    {
        return null;
    }

    /**
     * @return string
     */
    public function getUrl(): ?string
    {
        return $this->url;
    }

    /**
     * @param string $url
     * @return AbstractForm
     */
    public function setUrl(string $url): AbstractForm
    {
        $this->url = $url;
        return $this;
    }

    /**
     * @todo: remove this method from this class and from AbstractField
     *
     * @param $target
     * @return mixed|string
     */
    protected function getValueFromTarget($target)
    {
        $fieldName = $this->getId();

        try {
            return $target instanceof Model || $target instanceof \stdClass || is_object($target) ?
                $target->{$fieldName} : $target[$fieldName] ?? '';
        } catch (\Exception $e) {
            dd($e, $target);
        }
    }

    /**
     * @param FieldContract $field
     * @param mixed $updatedValue
     */
    protected function updateFieldValue(FieldContract $field, $updatedValue): void
    {
        if ($field instanceof FormContract) {
            if (is_array($this->target)) {
                $this->target[$field->getId()] = $updatedValue;
            } else {
                $this->target->{$field->getId()} = $updatedValue;
            }
        } else {
            $this->target = $updatedValue;
        }
    }


}
