<?php


namespace Formy\Contracts;


use Illuminate\Database\Eloquent\Model;
use Illuminate\View\View;

interface FormContract
{

    public function buildForm(FormBuilderContract $builder): FormBuilderContract;

    public function setLevel(int $level);

    public function getLevel(): int;

    public function getId(): string;

    public function getPrefix(): ?string;

    public function setPrefix(string $prefix);

    public function setPath(array $path);

    public function getPath(): array;

    public function render(): View;

    /**
     * @return Model|array|\stdClass
     */
    public function handle(array $request);

    public function prepare($target);

    /**
     * @return array|Model|\stdClass|null
     */
    public function getDefaultValue();

    public function getDefaultClass(): ?string;

    public function getUrl(): ?string;

    public function setUrl(string $url);

}
