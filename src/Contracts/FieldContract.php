<?php


namespace Formy\Contracts;


use Illuminate\View\View;

interface FieldContract
{

    public function getField(): string;

    public function setFormName(string $formName): FieldContract;

    public function getPrefix(): ?string;

    public function setPrefix(string $prefix);

    public function setPath(array $path);

    public function getPath(): array;

    public function setErrors(array $errors);

    public function render(): View;

    public function prepare($target);

    public function handle(array $request, $target);

    public function getDefaultParameters(): array;

    public function getValue();

}
