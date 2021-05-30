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

        $post = file_get_contents("php://input");
        $POST  = json_decode($post, true);
        $POST = $POST  ? $POST : $_POST;
        $data['user_name'] = isset($POST['user_name']) ? $POST['user_name'] : '';
        $data['user_email'] = isset($POST['user_email']) ? $POST['user_email'] : '';
        $data['user_phone'] = isset($POST['user_phone']) ? $POST['user_phone'] : '';
        $data['user_address'] = isset($POST['user_address']) ? $POST['user_address'] : '';
        $data['user_note'] = isset($POST['user_note']) ? $POST['user_note'] : '';
        $data['user_type'] = isset($POST['user_type']) ? $POST['user_type'] : '';
        $data['user_passowrd'] = isset($POST['user_passowrd']) ? $POST['user_passowrd'] : '';

        if (!$data['user_passowrd']) {
            return $this->fail("Password Required", 400);
        }else{
            $data['user_passowrd'] = password_hash($data['user_passowrd'], PASSWORD_DEFAULT);
        }

        
        $data['user_image'] = isset($POST['user_image']) ? $POST['user_image'] : '';

       ////Upload Image If Uploaded
        if ($data['user_image']) {
            list($type, $imageData) = explode(';', $data['user_image']);
            list(,$extension) = explode('/',$type);
            if (!in_array($extension, [ 'jpg', 'jpeg', 'gif', 'png' ])) {
                return $this->fail("Image Upload Failed", 400);
            }
            list(,$imageData)      = explode(',', $imageData);
            $fileName = uniqid().'.'.$extension;
            $imageData = base64_decode($imageData);
            file_put_contents(ROOTPATH.'public/uploads/users/'.$fileName, $imageData);
            $data['user_image'] = $fileName;
        }
        $user  = $userModel->insert($data);
        if ($user === false) {
            return $this->fail($userModel->errors(), 400);
        }else{
            return $this->respondCreated($user);
        }
    }
    public function show($id = NULL )
    {
        if(!Auth::$IS_LOGIN){
            return $this->fail('Access denied', 401,'TYU7890');
        }
        $userModel = new UsersModal();
        $user = $userModel->find($id);
        return $this->respond($user, 200);
    }
    public function filter($type = null)
    {
        if(!Auth::$IS_LOGIN){
            return $this->fail('Access denied', 401,'TYU7890');
        }
        $userModel = new UsersModal();
        $user = $userModel->where('user_type', $type)->findAll();
        return $this->respond($user, 200);
    }

    public function delete($id = NULL)
    {
        if(!Auth::$IS_LOGIN){
            return $this->fail('Access denied', 401,'TYU7890');
        }
        $userModel = new UsersModal();
        $service = $userModel->delete($id);
        return $this->respond($service, 200);
    }


}
