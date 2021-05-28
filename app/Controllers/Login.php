<?php
namespace App\Controllers;
use App\Models\Auth;
use App\Models\LoginModal;
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

    // ...
}
