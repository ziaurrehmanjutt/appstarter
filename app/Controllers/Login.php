<?php
namespace App\Controllers;
use App\Models\Auth;
use App\Models\UsersModal;
use App\Models\LoginModal;
use App\Models\StoresModal;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
class Login extends ResourceController
{
    use ResponseTrait;
    protected $modelName = 'App\Models\Login';
    protected $format    = 'json';
    private $auth;
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        if(!Auth::$IS_LOGIN){
            return $this->fail('Access denied', 401,'TYU7890');
        }

        $model = new LoginModal();
        $data = $model->myDetail(Auth::$USER_ID);
        return $this->respond($data, 200);
        return $data;
    }

    public function create()
    {

       
        $post = file_get_contents("php://input");
        $POST  =json_decode($post, true);
        $pass = isset($POST['user_passowrd']) ? $POST['user_passowrd'] : '';
        $login = isset($POST['user_email']) ? $POST['user_email'] : '';
       // return $this->fail( $POST, 400);
        if(!$pass || !$login){
            return $this->fail("Missing user_passowrd or user_email", 400);
        }
        $model = new LoginModal();
        $data['token']  = $model->do_login($login,$pass);


        if($data['token']){
            return $this->respondCreated($data);
            return $this->respond($data['token'], 200);
        }

        return $this->fail('Access denied', 401,'TYU7890');
        // $data = [
        //     'news'  => 'ok',
        //     'title' => 'News archive',
        // ];
        // return $this->respond($data, 200);
        // return $this->respondCreated();
        // return $data;
        // return view('login/login', $this->model->findAll());
        // return $this->respond($this->model->findAll());
    }

    public function register_admin()
    {
        $post = file_get_contents("php://input");
        $POST  = json_decode($post, true);
        $POST = $POST  ? $POST : $_POST;
        $data['user_name'] = isset($POST['user_name']) ? $POST['user_name'] : '';
        $data['user_email'] = isset($POST['user_email']) ? $POST['user_email'] : '';
        $data['user_phone'] = isset($POST['user_phone']) ? $POST['user_phone'] : '';
        $data['user_address'] = isset($POST['user_address']) ? $POST['user_address'] : '';
        $data['user_note'] = isset($POST['user_note']) ? $POST['user_note'] : '';
        $data['user_type'] = 1;
        $data['user_passowrd'] = isset($POST['user_passowrd']) ? $POST['user_passowrd'] : '';

        if (!$data['user_passowrd']) {
            return $this->fail("Password Required", 400);
        }else{
            $data['user_passowrd'] = password_hash($data['user_passowrd'], PASSWORD_DEFAULT);
        }

        $storeData['store_name'] = isset($POST['store_name']) ? $POST['store_name'] : '';
        $storeModel = new StoresModal();
        $store  = $storeModel->insert($storeData);

        //return $this->respondCreated($store);
        if ($store === false) {
            return $this->fail($storeModel->errors(), 400);
        }

        //return $this->fail("Password Required", 400);
        $data['store_id'] = $store;
        $userModel = new LoginModal();
        $user  = $userModel->insert($data);
        if ($user === false) {
            return $this->fail($userModel->errors(), 400);
        }else{
            return $this->respondCreated($user);

        }
    }
}
