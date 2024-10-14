<?php

namespace App\Database\Seeds;

use App\Models\UserModel;
use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $userModel = new UserModel();
        $userModel->where('id >=', 0)->delete();
        for ($i = 1; $i < 20; $i++) {
            $userModel->insert([
                'username' => 'customer ' . $i,
                'email' => "customer$i@gmail.com ",
                'password' => '12345'
            ]);
        }
        for ($i = 1; $i < 5; $i++) {
            $userModel->insert([
                'username' => 'salesman ' . $i,
                'email' => "salesman$i@gmail.com ",
                'password' => '12345',
                'type' => 'salesman'
            ]);
        }
        for ($i = 1; $i < 5; $i++) {
            $userModel->insert([
                'username' => 'provider ' . $i,
                'email' => "provider$i@gmail.com ",
                'password' => '12345',
                'type' => 'provider'
            ]);
        }
        $userModel->insert([
            'username' => 'admin',
            'email' => "admin@gmail.com ",
            'password' => '12345',
            'type' => 'admin'
        ]);
    }
}
