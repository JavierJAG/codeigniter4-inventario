<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ProductTag extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'product_id' => [
                'type' => 'int',
                'unsigned' => true
            ],
            'tag_id' => [
                'type' => 'int',
                'unsigned' => true
            ]
        ]);
        $this->forge->addPrimaryKey(['product_id','tag_id']);
        $this->forge->addForeignKey('product_id','products','id');
        $this->forge->addForeignKey('tag_id','tags','id');
        $this->forge->createTable('product_tag');
    }

    public function down()
    {
        $this->forge->dropTable('product_tag');
    }
}
