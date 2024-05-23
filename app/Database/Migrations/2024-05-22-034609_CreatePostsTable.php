<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePostsTable extends Migration
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
            'author_id' => [
                'type' => 'int',
                'constraint' => 11
            ],
            'category_id' => [
                'type' => 'int',
                'constraint' => 11
            ],
            'title' => [
                'type' => 'varchar',
                'constraint' => 255
            ],
            'slug' => [
                'type' => 'varchar',
                'constraint' => 255
            ],
            'content' => [
                'type' => 'text',
            ],
            'featured_image' => [
                'type' => 'varchar',
                'constraint' => 255
            ],
            'tags' => [
                'type' => 'text',
                'null' => true
            ],
            'meta_keywords' => [
                'type' => 'text',
                "null" => true
            ],
            'meta_description' => [
                'type' => 'text',
                'null' => true
            ],
            'visibility' => [
                'type' => 'int',
                'constraint' => 11,
                'default' => 1
            ],
            'created_at timestamp default current_timestamp',
            'updated_at timestamp default current_timestamp on update current_timestamp'
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('posts');
    }

    public function down()
    {
        //
        $this->forge->dropTable('posts');
    }
}
