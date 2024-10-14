<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ProductUserControl extends Migration
{
    public function up()
    {
       $this->forge->addField([
        'id'=>[
            'type'=>'int',
            'unsigned'=>true,
            'auto_increment'=>true
        ],
        'created_at'=>[
            'type'=>'TIMESTAMP',
            
        ],
        'updated_at'=>[
            'type'=>'TIMESTAMP',
        ],
        'product_control_id'=>[
            'type'=>'int',
            'unsigned'=>true,
            'constraint'=>10
        ],
        'description'=>[
            'type'=>'text',
        ],
        'direction'=>[
            'type'=>'text',
        ]
    ]);

    $this->forge->addPrimaryKey('id');
    $this->forge->addForeignKey('product_control_id','products_control','id','cascade','cascade');
    $this->forge->createTable('products_users_control');
    }

    public function down()
    {
        $this->forge->dropTable('products_users_control');
    }
}
