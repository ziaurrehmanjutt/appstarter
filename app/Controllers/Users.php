<?php

namespace App\Controllers;
use App\Models\Auth;
use App\Models\UsersModal;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;

class Users extends ResourceController
{
    use ResponseTrait;
    protected $modelName = 'App\Models\UsersModal';
    protected $format    = 'json';

    public function __construct()
    {
        parent::__construct();
    }
    public function index()
    {
        if(!Auth::$IS_LOGIN){
            return $this->fail('Access denied', 401,'TYU7890');
        }
        $userModel = new UsersModal();
        $user = $userModel->findAll();
        return $this->respond($user, 200);
    }

    public function create()
    {
        if(!Auth::$IS_LOGIN){
            return $this->fail('Access denied', 401,'TYU7890');
        }
        $userModel = new UsersModal();
        $data['user_name'] = $this->request->getPost('user_name');
        $data['user_email'] = $this->request->getPost('user_email');
        $data['user_type'] = $this->request->getPost('user_type');
        $data['user_passowrd'] = password_hash($this->request->getPost('user_passowrd'), PASSWORD_DEFAULT);
        $user  = $userModel->insert($data);
        if ($user === false) {
            return $this->fail($userModel->errors(), 400);
        }else{
            return $this->respondCreated($user);

        }
    }
    public function show($id = NULL)
    {
        if(!Auth::$IS_LOGIN){
            return $this->fail('Access denied', 401,'TYU7890');
        }
        $userModel = new UsersModal();
        $user = $userModel->find($id);
        return $this->respond($user, 200);
    }



    // ...
}
