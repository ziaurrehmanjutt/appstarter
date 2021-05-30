<?php

namespace App\Controllers;
use App\Models\Auth;
use App\Models\CitiesModal;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;

class Cities extends ResourceController
{
    use ResponseTrait;
    protected $modelName = 'App\Models\CitiesModal';
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
        $cityModel = new CitiesModal();
        $service = $cityModel->findAll();
        return $this->respond($service, 200);
    }

    public function create()
    {
        if(!Auth::$IS_LOGIN){
            return $this->fail('Access denied', 401,'TYU7890');
        }
        $cityModel = new CitiesModal();

        $post = file_get_contents("php://input");
        $POST  =json_decode($post, true);
        $POST = $POST  ? $POST : $_POST;
        $data['city_name'] = isset($POST['city_name']) ? $POST['city_name'] : '';
        $data['country_name'] = isset($POST['country_name']) ? $POST['country_name'] : '';
        $data['seller_id']  = Auth::$USER_ID;
        

        $city  = $cityModel->insert($data);
        if ($city === false) {
            return $this->fail($cityModel->errors(), 400);
        }else{
            return $this->respondCreated($city);

        }
    }
    public function show($id = NULL)
    {
        if(!Auth::$IS_LOGIN){
            return $this->fail('Access denied', 401,'TYU7890');
        }
        $cityModel = new CitiesModal();
        $city = $cityModel->find($id);
        return $this->respond($city, 200);
    }

    public function delete($id = NULL)
    {
        if(!Auth::$IS_LOGIN){
            return $this->fail('Access denied', 401,'TYU7890');
        }
        $cityModel = new CitiesModal();
        $service = $cityModel->delete($id);
        return $this->respond($service, 200);
    }

    public function update($id = NULL)
    {
        if(!Auth::$IS_LOGIN){
            return $this->fail('Access denied', 401,'TYU7890');
        }
        $cityModel = new CitiesModal();


        ///Getting Post Data
        $post = file_get_contents("php://input");
        $POST  =json_decode($post, true);
        $POST = $POST  ? $POST : $_POST;
        $data['city_name'] = isset($POST['city_name']) ? $POST['city_name'] : '';
        
        $service = $cityModel->update($id, $data);
        return $this->respond($service, 200);
    }
}
