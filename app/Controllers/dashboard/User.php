<?php

namespace App\Controllers\Dashboard;

use App\Controllers\BaseController;
use App\Models\UserModel;
use CodeIgniter\API\ResponseTrait;

class User extends BaseController
{
    use ResponseTrait;

    public function getUsers($type){
        $userModel = new UserModel();
        return $this->respond($userModel->where('type',$type)->findAll());
    }
}
