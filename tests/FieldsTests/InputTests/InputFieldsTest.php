<?php


namespace Formy\Tests\FieldsTests\InputTests;


use Formy\Contracts\FormContract;
use Formy\Fields\EmailField;
use Formy\Fields\NumberField;
use Formy\Fields\PasswordField;
use Formy\Fields\TextField;
use Formy\Providers\FormyServiceProvider;
use Formy\Tests\Forms\EntryFormWithDynamicField;
use Orchestra\Testbench\TestCase;

class InputFieldsTest extends TestCase
{
    protected function getPackageProviders($app)
    {
        return [ FormyServiceProvider::class ];
    }

    /**
     * @test
     * @dataProvider formsProvider
     */
    public function canCreateFormWithAFieldAndHandleIt(FormContract $form, $request, $needed)
    {
        $updated = $form->handle($request);
        $this->assertEquals($needed, $updated);
    }

    public function formsProvider()
    {
        $fields = [
            TextField::class,
            PasswordField::class,
            EmailField::class,
            NumberField::class
        ];

        $neededValue = 'Value';
        $mockRequest = [
            'entry' => [
                'input' => $neededValue
            ]
        ];
        $updatedValue = [ 'input' => $neededValue ];

        return array_map(function ($field) use ($mockRequest, $updatedValue) {
            /** @var EntryFormWithDynamicField $form */
            $form = EntryFormWithDynamicField::create([]);
            return [ $form->setFieldType($field), $mockRequest, $updatedValue ];
        }, $fields);
    }

}
