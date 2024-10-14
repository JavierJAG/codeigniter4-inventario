<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ProductControl extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'=>[
                'type'=>'INT',
                'unsigned'=>TRUE,
                'auto_increment'=>TRUE
            ],

            'count'=>[
                'type'=>'INT',
                'unsigned'=>TRUE
            ],
            'product_id'=>[
                'type'=>'INT',
                'unsigned'=>TRUE
            ],
            'stock'=>[
                'type'=>'INT',
                'unsigned'=>TRUE
            ],'type'=>[
                'type'=>'ENUM',
                'constraint'=>['exit','entry']
            ],

            'created_at' =>[
                'type' => 'TIMESTAMP'
            ],
            'updated_at' =>[
                'type' => 'TIMESTAMP'
            ]
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('product_id','products','id','CASCADE','CASCADE');
        $this->forge->createTable('products_control');
    }

    public function down()
    {
        $this->forge->dropTable('products_control');
    }
}
