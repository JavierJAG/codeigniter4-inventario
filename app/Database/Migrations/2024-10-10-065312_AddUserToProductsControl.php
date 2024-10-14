<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddUserToProductsControl extends Migration
{
    public function up()
    {
        $this->forge->addColumn('products_control',[
            'user_id'=>[
                'type'=>'int',
                'constraint'=>10,
                'unsigned'=>true
            ]
            ]);
            $this->forge->addForeignKey('user_id','users','id','cascade','cascade');
    }

    public function down()
    {
        $this->forge->dropColumn('products_control','user_id');
    }
}
