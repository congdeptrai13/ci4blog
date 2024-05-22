<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSubCategoriesTable extends Migration
{
    public function up()
    {
        //
        $this->forge->addField([
            'id' => [
                'type' => 'int',
                'unsigned' => true,
                'auto_increment' => true
            ],
            'name' => [
                'type' => 'varchar',
                'constraint' => '255'
            ],
            'slug' => [
                'type' => 'varchar',
                'constraint' => '255'
            ],
            'parent_cat' => [
                'type' => 'int',
                'constraint' => 11,
                'default' => 0
            ],
            'description' => [
                'type' => 'text',
                'null' => true,
            ],
            'ordering' => [
                'type' => 'int',
                'constraint' => 11,
                'default' => 10000
            ],
            'created_at timestamp default current_timestamp',
            'updated_at timestamp default current_timestamp on update current_timestamp'
        ]);


        $this->forge->addKey('id');
        $this->forge->createTable('sub_categories');
    }

    public function down()
    {
        //
        $this->forge->dropTable('sub_categories');
    }
}
