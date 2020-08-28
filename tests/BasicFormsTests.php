<?php

namespace Formy\Tests;

use Formy\Providers\FormyServiceProvider;
use Orchestra\Testbench\TestCase;
use Formy\Tests\Forms\EntryForm;
use Formy\Tests\Forms\EntryFormWithSubform;

class BasicFormsTests extends TestCase
{

    protected function getPackageProviders($app)
    {
        return [ FormyServiceProvider::class ];
    }

    /**
     * @test
     */
    public function canUpdateFields()
    {
        $form = EntryForm::create([]);
        $updated = $form->handle([ 'entry' => [ 'title' => 'Some Name' ] ]);

        $this->assertEquals([ 'title' => 'Some Name' ], $updated);
    }

    /**
     * @test
     */
    public function canHandleFormWithSubforms()
    {
        $form = EntryFormWithSubform::create([
            'title' => 'Title',
            'inner' => [
                'fieldName' => 'value'
            ]
        ]);

        $updated = $form->handle([
            'entry' => [
                'title' => 'New title',
                'inner' => [
                    'fieldName' => 'Updated'
                ]
            ]
        ]);

        $this->assertEquals([
            'title' => 'New title',
            'inner' => [
                'fieldName' => 'Updated'
            ]
        ], $updated);
    }

}
