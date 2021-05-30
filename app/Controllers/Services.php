<?php

namespace App\Controllers;
use App\Models\Auth;
use App\Models\ServicesModal;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;

class Services extends ResourceController
{
    use ResponseTrait;
    protected $modelName = 'App\Models\ServicesModal';
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
        $serviceModel = new ServicesModal();
        $service = $serviceModel->findAll();
        return $this->respond($service, 200);
    }

    public function create()
    {
        if(!Auth::$IS_LOGIN){
            return $this->fail('Access denied', 401,'TYU7890');
        }
        $serviceModel = new ServicesModal();

        $post = file_get_contents("php://input");
        $POST  =json_decode($post, true);
        $POST = $POST  ? $POST : $_POST;
        // $service['p'] = WRITEPATH;
        // return $this->respond($service, 200);
        $data['service_name'] = isset($POST['service_name']) ? $POST['service_name'] : '';
        $data['service_descriptions'] = isset($POST['service_descriptions']) ? $POST['service_descriptions'] : '';
        $data['service_image'] = isset($POST['service_image']) ? $POST['service_image'] : '';
        $data['service_seller']  = Auth::$USER_ID;
        
        if (!$data['service_image']) {
            return $this->fail("Image Required", 400);
        }
        // $data = 'data:image/png;base64,AAAFBfj42Pj4';
        list($type, $imageData) = explode(';', $data['service_image']);
        list(,$extension) = explode('/',$type);

        if (!in_array($extension, [ 'jpg', 'jpeg', 'gif', 'png' ])) {
            return $this->fail("Image Upload Failed", 400);
        }

        list(,$imageData)      = explode(',', $imageData);
        $fileName = uniqid().'.'.$extension;
        $imageData = base64_decode($imageData);


        // file_put_contents(WRITEPATH.'uploads/'.$fileName, $imageData);
        file_put_contents(ROOTPATH.'public/uploads/services/'.$fileName, $imageData);


        $data['service_image'] = $fileName;

        $user  = $serviceModel->insert($data);
        if ($user === false) {
            return $this->fail($serviceModel->errors(), 400);
        }else{
            return $this->respondCreated($user);

        }
    }
    public function show($id = NULL)
    {
        if(!Auth::$IS_LOGIN){
            return $this->fail('Access denied', 401,'TYU7890');
        }
        $serviceModel = new ServicesModal();
        $service = $serviceModel->find($id);
        return $this->respond($service, 200);
    }

    public function delete($id = NULL)
    {
        if(!Auth::$IS_LOGIN){
            return $this->fail('Access denied', 401,'TYU7890');
        }
        $serviceModel = new ServicesModal();
        $service = $serviceModel->delete($id);
        return $this->respond($service, 200);
    }

    public function update($id = NULL)
    {
        if(!Auth::$IS_LOGIN){
            return $this->fail('Access denied', 401,'TYU7890');
        }
        $serviceModel = new ServicesModal();


        ///Getting Post Data
        $post = file_get_contents("php://input");
        $POST  =json_decode($post, true);
        $POST = $POST  ? $POST : $_POST;
        $data['service_name'] = isset($POST['service_name']) ? $POST['service_name'] : '';
        $data['service_descriptions'] = isset($POST['service_descriptions']) ? $POST['service_descriptions'] : '';
        $imageData = isset($POST['service_image']) ? $POST['service_image'] : '';

       ////Upload Image If Uploaded
        if ($imageData) {
            list($type, $imageData) = explode(';', $data['service_image']);
            list(,$extension) = explode('/',$type);
            if (!in_array($extension, [ 'jpg', 'jpeg', 'gif', 'png' ])) {
                return $this->fail("Image Upload Failed", 400);
            }
            list(,$imageData)      = explode(',', $imageData);
            $fileName = uniqid().'.'.$extension;
            $imageData = base64_decode($imageData);
            file_put_contents(ROOTPATH.'public/uploads/services/'.$fileName, $imageData);
            $data['service_image'] = $fileName;
        }
        
        $service = $serviceModel->update($id, $data);
        return $this->respond($service, 200);
    }
}
