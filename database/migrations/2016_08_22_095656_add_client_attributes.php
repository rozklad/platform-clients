<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddClientAttributes extends Migration {

    protected $attributes = [
        [
            'name' => 'Client address',
            'type' => 'textarea',
            'description' => 'Client address that will be shown on bill',
            'slug' => 'client_address',
        ]
    ];

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $attributesRepo = app('Platform\Attributes\Repositories\AttributeRepositoryInterface');

        foreach( $this->attributes as $attribute )
        {
            $attributesRepo->firstOrCreate([
                'namespace'   => \Sanatorium\Clients\Models\Client::getEntityNamespace(),
                'name'        => $attribute['name'],
                'description' => $attribute['description'],
                'type'        => $attribute['type'],
                'slug'        => $attribute['slug'],
                'enabled'     => 1,
            ]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $attributesRepo = app('Platform\Attributes\Repositories\AttributeRepositoryInterface');

        foreach( $this->attributes as $attribute )
        {
            $attributesRepo->where('slug', $attribute['slug'])->delete();
        }
    }

}
