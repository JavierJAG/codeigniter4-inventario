<?php

namespace App\Database\Seeds;

use App\Models\TagModel;
use CodeIgniter\Database\Seeder;

class Etiquetas extends Seeder
{
    public function run()
    {
        $tagModel = new TagModel();
        $tagModel->where('id >=',0)->delete();
        for ($i = 1; $i < 20; $i++) {
            $tagModel->insert([
                'name' => 'Etiqueta ' . $i
            ]);
        }
    }
}
