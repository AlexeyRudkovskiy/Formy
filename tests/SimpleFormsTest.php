<?php


namespace Formy\Tests;


use Formy\Providers\FormyServiceProvider;
use Formy\Tests\Classes\SimpleObject;
use Formy\Tests\Database\Migrations\CreateUnicornsHeadTable;
use Formy\Tests\Database\Migrations\CreateUnicornsTailTable;
use Formy\Tests\Forms\EntryFormWithSaveOnHandle;
use Formy\Tests\Traits\LoadMigration;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Orchestra\Testbench\TestCase;
use Formy\Tests\Forms\EntryForm;

class SimpleFormsTest extends TestCase
{
    use RefreshDatabase;
    use LoadMigration;

    protected function getEnvironmentSetUp($app)
    {
        $this->loadMigration(CreateUnicornsHeadTable::class);

        (new CreateUnicornsHeadTable())->up();
    }

    protected function getPackageProviders($app)
    {
        return [ FormyServiceProvider::class ];
    }

    /**
     * @test
     * @dataProvider provider
     */
    public function canCreateAndHandleSimpleFormWithArrayData($request, $needed)
    {
        $form = EntryForm::create([]);
        $updated = $form->handle($request);

        $this->assertEquals([ 'title' => $needed ], $updated);
    }

    /**
     * @test
     * @dataProvider provider
     */
    public function canCreateAndHandleSimpleFormWithObjectData($request, $needed)
    {
        $newObject = new SimpleObject();
        $form = EntryForm::create($newObject);
        $updated = $form->handle($request);

        $neededObject = new SimpleObject($needed);

        $this->assertEquals($neededObject, $updated);
    }

    /**
     * @test
     * @dataProvider provider
     */
    public function canCreateAndHandleSimpleFormWithDefaultData($request, $needed)
    {
        $form = EntryFormWithSaveOnHandle::create();
        $updated = $form->handle($request);

        $neededValue = new SimpleObject($needed);
        $this->assertEquals($neededValue, $updated);
    }

    /** @test */
    public function isDatabaseCreated()
    {
        $post = new \Formy\Tests\Database\Models\UnicornHead();
        $post->title = 'Hello world!';
        $post->save();

        $loadedPost = \Formy\Tests\Database\Models\UnicornHead::first();
        $this->assertEquals($post->title, $loadedPost->title);

        return $loadedPost;
    }

    /**
     * @test
     * @depends isDatabaseCreated
     * @dataProvider provider
     */
    public function canCreateAndHandleSimpleFormWithModelData($request, $needed, $record)
    {
        $form = EntryFormWithSaveOnHandle::create($record);
        $updated = $form->handle($request);
        $updated->save();

        $this->assertEquals($needed, $updated->title);
    }

    /**
     * @test
     * @depends isDatabaseCreated
     * @dataProvider provider
     */
    public function canCreateAndHandleFormWithModelDataAndSaveOnHandle($request, $needed, $record)
    {
        $form = EntryFormWithSaveOnHandle::create($record);
        $updated = $form->handle($request);

        $this->assertEquals($needed, $updated->title);
    }

    public function provider()
    {
        return [
            [ [ 'entry' => [ 'title' => 'Hello World!' ] ], 'Hello World!' ],
            [ [ 'entry' => [ 'title' => 1 ] ], 1 ],
            [ [ 'entry' => [ 'title' => null ] ], null ]
        ];
    }

}
