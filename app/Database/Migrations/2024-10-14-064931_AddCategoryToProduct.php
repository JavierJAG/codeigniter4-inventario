<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddCategoryToProduct extends Migration
{
    public function up()
    {
        $this->forge->addColumn('products',[
            'column category_id int(10) unsigned',
            'constraint products_category_id_foreign foreign key(category_id) references categories(id)'
        ]);
    }

    public function down()
    {
        $this->forge->dropForeignKey('products','products_category_id_foreign');
        $this->forge->dropColumn('products','category_id');
    }
}
