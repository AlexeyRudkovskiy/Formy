<?php


namespace Formy\Tests\Traits;


trait LoadMigration
{

    protected $declaredClasses = null;

    public function loadMigration(string $fullClassName)
    {
        if ($this->declaredClasses === null) {
            $this->declaredClasses = get_declared_classes();
        }

        $classParts = explode('\\', $fullClassName);
        $className = array_pop($classParts);

        if (!in_array($fullClassName, $this->declaredClasses)) {
            include_once __DIR__ . '/../Database/Migrations/' . $className . '.php';
        }
    }

}
