<?php


namespace Formy\Fields;


use Formy\Contracts\AbstractField;
use Formy\Contracts\IgnoreOnHandle;
use Illuminate\View\View;

class ButtonField extends AbstractField implements IgnoreOnHandle
{

    /** @var string  */
    protected $type = 'button';

    /** @var string  */
    protected $value = 'Button';

    public function render(): View
    {
        return view('formy::field.button')
            ->with('type', $this->getType())
            ->with('value', $this->getValue());
    }

    public function renderTable()
    {
        // TODO: Implement renderTable() method.
    }

    public function handle(array $request, $target)
    {
        // TODO: Implement apply() method.
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
     * @return ButtonField
     */
    public function setType(string $type): ButtonField
    {
        $this->type = $type;
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
     * @return ButtonField
     */
    public function setValue(string $value): ButtonField
    {
        $this->value = $value;
        return $this;
    }

    public function prepare($target)
    {
        /// empty
    }

}
