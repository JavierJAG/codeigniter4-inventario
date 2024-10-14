<?php

namespace App\Database\Seeds;

use App\Models\CategoryModel;
use CodeIgniter\Database\Seeder;

class Categories extends Seeder
{
    public function run()
    {
        $categoryModel = new CategoryModel();
        $categoryModel->where('id >=',0)->delete();
        for ($i = 1; $i < 20; $i++) {
            $categoryModel->insert([
                'name' => 'Categoría ' . $i
            ]);
        }
    }
}
