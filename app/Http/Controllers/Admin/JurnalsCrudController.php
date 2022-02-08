<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Http\Requests\JurnalsRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class JurnalsCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class JurnalsCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    // // use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    // use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    // use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Jurnals::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/jurnals');
        CRUD::setEntityNameStrings('jurnals', 'jurnals');
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::column('id');
        CRUD::addColumn([  
            // any type of relationship
            'name'         => 'user', // name of relationship method in the model
            'type'         => 'relationship',
            'label'        => 'user', // Table column heading
            // OPTIONAL
            // 'entity'    => 'tags', // the method that defines the relationship in your Model
            // 'attribute' => 'name', // foreign key attribute that is shown to user
            // 'model'     => App\Models\User::class, // foreign key model
         ]);
        // CRUD::column('created_at');
        // CRUD::column('updated_at'); 
        CRUD::column('path')->label('image');
        CRUD::column('tanggal');
        CRUD::column('kegiatan')->type('text');
        $this->crud->addFilter([
            'name'  => 'user_id',
            'type'  => 'select2',
            'label' => 'User'
          ], function () {
            return User::all()->keyBy('id')->pluck('name', 'id')->toArray();
          }, function ($value) { // if the filter is active
            $this->crud->addClause('where', 'user_id', $value);
          });

        /**
         * Columns can be defined using the fluent syntax or array syntax:
         * - CRUD::column('price')->type('number');
         * - CRUD::addColumn(['name' => 'price', 'type' => 'number']); 
         */
    }

    /**
     * Define what happens when the Create operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(JurnalsRequest::class);

        CRUD::field('id');
        CRUD::field('created_at');
        CRUD::field('updated_at');
        CRUD::field('title');
        CRUD::field('path');
        CRUD::field('tanggal');
        CRUD::field('kegiatan');

        /**
         * Fields can be defined using the fluent syntax or array syntax:
         * - CRUD::field('price')->type('number');
         * - CRUD::addField(['name' => 'price', 'type' => 'number'])); 
         */
    }

    /**
     * Define what happens when the Update operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }

    protected function setupShowOperation()
    {
        CRUD::column('id');
        // CRUD::column('created_at');
        // CRUD::column('updated_at');
        CRUD::addColumn([  
            // any type of relationship
            'name'         => 'user', // name of relationship method in the model
            'type'         => 'relationship',
            'label'        => 'user', // Table column heading
            // OPTIONAL
            // 'entity'    => 'tags', // the method that defines the relationship in your Model
            // 'attribute' => 'name', // foreign key attribute that is shown to user
            // 'model'     => App\Models\User::class, // foreign key model
         ]);
        CRUD::addColumn(['name' => 'path', 'type' => 'image', 'height' => '500px', 'label' => 'image']);  
        // CRUD::column('path')->type('image')->height('500px');
        CRUD::column('tanggal');
        CRUD::column('kegiatan')->type('textarea');

        /**
         * Columns can be defined using the fluent syntax or array syntax:
         * - CRUD::column('price')->type('number');
         * - CRUD::addColumn(['name' => 'price', 'type' => 'number']); 
         */
    }
}
