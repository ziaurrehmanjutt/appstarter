<?php

namespace App\Controllers;
use App\Models\Auth;
use App\Models\ZonesModal;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;

class Zones extends ResourceController
{
    use ResponseTrait;
    protected $modelName = 'App\Models\ZonesModal';
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
        $zoneModal = new ZonesModal();
        if(isset($_GET) && isset($_GET['city'])){
            $zone = $zoneModal->where('zone_city', $_GET['city'])->findAll();
            return $this->respond($zone, 200);
        }
      
        $zone = $zoneModal->findAll();
        return $this->respond($zone, 200);
    }

    public function create()
    {
        if(!Auth::$IS_LOGIN){
            return $this->fail('Access denied', 401,'TYU7890');
        }


        $post = file_get_contents("php://input");
        $POST  =json_decode($post, true);
        $POST = $POST  ? $POST : $_POST;
        $data['zone_name'] = isset($POST['zone_name']) ? $POST['zone_name'] : '';
        $data['zone_descriptions'] = isset($POST['zone_descriptions']) ? $POST['zone_descriptions'] : '';
        $data['zone_address'] = isset($POST['zone_address']) ? $POST['zone_address'] : '';
        $data['zone_lat'] = isset($POST['zone_lat']) ? $POST['zone_lat'] : '';
        $data['zone_lng'] = isset($POST['zone_lng']) ? $POST['zone_lng'] : '';
        $data['zone_city'] = isset($POST['zone_city']) ? $POST['zone_city'] : '';
        $data['zone_seller']  = Auth::$USER_ID;
        

        $zoneModal = new ZonesModal();
        $zone  = $zoneModal->insert($data);
        if ($zone === false) {
            return $this->fail($zoneModal->errors(), 400);
        }else{
            return $this->respondCreated($zone);

        }
    }
    public function show($id = NULL)
    {
        if(!Auth::$IS_LOGIN){
            return $this->fail('Access denied', 401,'TYU7890');
        }
        $zoneModal = new ZonesModal();
        $zone = $zoneModal->find($id);
        return $this->respond($zone, 200);
    }

    public function delete($id = NULL)
    {
        if(!Auth::$IS_LOGIN){
            return $this->fail('Access denied', 401,'TYU7890');
        }
        $zoneModal = new ZonesModal();
        $zone = $zoneModal->delete($id);
        return $this->respond($zone, 200);
    }

    public function update($id = NULL)
    {
        if(!Auth::$IS_LOGIN){
            return $this->fail('Access denied', 401,'TYU7890');
        }

        ///Getting Post Data
        $post = file_get_contents("php://input");
        $POST  =json_decode($post, true);
        $POST = $POST  ? $POST : $_POST;
        $data['zone_name'] = isset($POST['zone_name']) ? $POST['zone_name'] : '';
        $data['zone_descriptions'] = isset($POST['zone_descriptions']) ? $POST['zone_descriptions'] : '';
        $data['zone_address'] = isset($POST['zone_address']) ? $POST['zone_address'] : '';
        $data['zone_lat'] = isset($POST['zone_lat']) ? $POST['zone_lat'] : '';
        $data['zone_lng'] = isset($POST['zone_lng']) ? $POST['zone_lng'] : '';
        $data['zone_city'] = isset($POST['zone_city']) ? $POST['zone_city'] : '';
        
        $zoneModal = new ZonesModal();
        $zone = $zoneModal->update($id, $data);
        return $this->respond($zone, 200);
    }
}
