<?php

namespace App\Controllers;
use App\Models\Auth;
use App\Models\StoresModal;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;

class Stores extends ResourceController
{
    use ResponseTrait;
    protected $modelName = 'App\Models\StoresModal';
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
        $storeModal = new StoresModal();
        $store = $storeModal->find(Auth::$USER_ID);
        return $this->respond($store, 200);
    }

    // public function create()
    // {
    //     if(!Auth::$IS_LOGIN){
    //         return $this->fail('Access denied', 401,'TYU7890');
    //     }
    //     $productModel = new ProductsModal();

    //     $post = file_get_contents("php://input");
    //     $POST  =json_decode($post, true);
    //     $POST = $POST  ? $POST : $_POST;
    //     // $service['p'] = WRITEPATH;
    //     // return $this->respond($service, 200);
    //     $data['product_name'] = isset($POST['product_name']) ? $POST['product_name'] : '';
    //     $data['product_short'] = isset($POST['product_short']) ? $POST['product_short'] : '';
    //     $data['product_long'] = isset($POST['product_long']) ? $POST['product_long'] : '';
    //     $data['product_image'] = isset($POST['product_image']) ? $POST['product_image'] : '';
    //     $data['product_discount_price'] = isset($POST['product_discount_price']) ? $POST['product_discount_price'] : '';
    //     $data['product_category'] = isset($POST['product_category']) ? $POST['product_category'] : '';
    //     $data['product_price'] = isset($POST['product_price']) ? $POST['product_price'] : '';
    //     $data['product_seller']  = Auth::$USER_ID;
    //     //'', '','','','','','','','product_quantity','product_status'
    //     if (!$data['product_image']) {
    //         return $this->fail("Image Required", 400);
    //     }
    //     // $data = 'data:image/png;base64,AAAFBfj42Pj4';
    //     list($type, $imageData) = explode(';', $data['product_image']);
    //     list(,$extension) = explode('/',$type);

    //     if (!in_array($extension, [ 'jpg', 'jpeg', 'gif', 'png' ])) {
    //         return $this->fail("Image Upload Failed", 400);
    //     }

    //     list(,$imageData)      = explode(',', $imageData);
    //     $fileName = uniqid().'.'.$extension;
    //     $imageData = base64_decode($imageData);
    //     file_put_contents(ROOTPATH.'public/uploads/products/'.$fileName, $imageData);


    //     $data['product_image'] = $fileName;

    //     $user  = $productModel->insert($data);
    //     if ($user === false) {
    //         return $this->fail($productModel->errors(), 400);
    //     }else{
    //         return $this->respondCreated($user);

    //     }
    // }
    // public function show($id = NULL)
    // {
    //     if(!Auth::$IS_LOGIN){
    //         return $this->fail('Access denied', 401,'TYU7890');
    //     }
    //     $productModel = new ProductsModal();
    //     $service = $productModel->find($id);
    //     return $this->respond($service, 200);
    // }

    // public function delete($id = NULL)
    // {
    //     if(!Auth::$IS_LOGIN){
    //         return $this->fail('Access denied', 401,'TYU7890');
    //     }
    //     $productModel = new ProductsModal();
    //     $service = $productModel->delete($id);
    //     return $this->respond($service, 200);
    // }

    public function update($id = NULL)
    {
        if(!Auth::$IS_LOGIN){
            return $this->fail('Access denied', 401,'TYU7890');
        }
       


        ///Getting Post Data
        $post = file_get_contents("php://input");
        $POST  =json_decode($post, true);
        $POST = $POST  ? $POST : $_POST;


        $data['store_name'] = isset($POST['store_name']) ? $POST['store_name'] : '';
        $data['store_description'] = isset($POST['store_description']) ? $POST['store_description'] : '';
        $data['store_address'] = isset($POST['store_address']) ? $POST['store_address'] : '';
        $data['store_city'] = isset($POST['store_city']) ? $POST['store_city'] : '';
        $data['store_zone'] = isset($POST['store_zone']) ? $POST['store_zone'] : '';
        $data['stor_lat'] = isset($POST['stor_lat']) ? $POST['stor_lat'] : '';
        $data['store_lng'] = isset($POST['store_lng']) ? $POST['store_lng'] : '';

        $imageData = isset($POST['store_image']) ? $POST['store_image'] : '';
        $imageData2 = isset($POST['store_banner']) ? $POST['store_banner'] : '';

       ////Upload Image If Uploaded
        if ($imageData) {
            list($type, $imageData) = explode(';', $imageData);
            list(,$extension) = explode('/',$type);
            if (!in_array($extension, [ 'jpg', 'jpeg', 'gif', 'png' ])) {
                return $this->fail("Image Upload Failed", 400);
            }
            list(,$imageData)      = explode(',', $imageData);
            $fileName = uniqid().'.'.$extension;
            $imageData = base64_decode($imageData);
            file_put_contents(ROOTPATH.'public/uploads/stores/'.$fileName, $imageData);
            $data['store_image'] = $fileName;
        }
        if ($imageData2) {
            list($type, $imageData) = explode(';', $imageData2);
            list(,$extension) = explode('/',$type);
            if (!in_array($extension, [ 'jpg', 'jpeg', 'gif', 'png' ])) {
                return $this->fail("Image Upload Failed", 400);
            }
            list(,$imageData)      = explode(',', $imageData);
            $fileName = uniqid().'.'.$extension;
            $imageData = base64_decode($imageData);
            file_put_contents(ROOTPATH.'public/uploads/stores/'.$fileName, $imageData);
            $data['store_banner'] = $fileName;
        }
        
        $storeModal = new StoresModal();
        $store = $storeModal->update($id, $data);
        return $this->respond($store, 200);
    }

    // public function filter($type = null)
    // {
    //     if(!Auth::$IS_LOGIN){
    //         return $this->fail('Access denied', 401,'TYU7890');
    //     }
    //     $productModel = new ProductsModal();
    //     $user = $productModel->where('product_category', $type)->findAll();
    //     return $this->respond($user, 200);
    // }
}
