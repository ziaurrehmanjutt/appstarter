<?php

namespace App\Controllers;
use App\Models\Auth;
use App\Models\ProductsModal;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;

class Products extends ResourceController
{
    use ResponseTrait;
    protected $modelName = 'App\Models\ProductsModal';
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
        $productModel = new ProductsModal();
        $products = $productModel->where('product_seller', Auth::$USER_ID)->findAll();
        return $this->respond($products, 200);
    }

    public function create()
    {
        if(!Auth::$IS_LOGIN){
            return $this->fail('Access denied', 401,'TYU7890');
        }
        $productModel = new ProductsModal();

        $post = file_get_contents("php://input");
        $POST  =json_decode($post, true);
        $POST = $POST  ? $POST : $_POST;
        // $service['p'] = WRITEPATH;
        // return $this->respond($service, 200);
        $data['product_name'] = isset($POST['product_name']) ? $POST['product_name'] : '';
        $data['product_short'] = isset($POST['product_short']) ? $POST['product_short'] : '';
        $data['product_long'] = isset($POST['product_long']) ? $POST['product_long'] : '';
        $data['product_image'] = isset($POST['product_image']) ? $POST['product_image'] : '';
        $data['product_discount_price'] = isset($POST['product_discount_price']) ? $POST['product_discount_price'] : '';
        $data['product_category'] = isset($POST['product_category']) ? $POST['product_category'] : '';
        $data['product_price'] = isset($POST['product_price']) ? $POST['product_price'] : '';
        $data['product_seller']  = Auth::$USER_ID;
        //'', '','','','','','','','product_quantity','product_status'
        if (!$data['product_image']) {
            return $this->fail("Image Required", 400);
        }
        // $data = 'data:image/png;base64,AAAFBfj42Pj4';
        list($type, $imageData) = explode(';', $data['product_image']);
        list(,$extension) = explode('/',$type);

        if (!in_array($extension, [ 'jpg', 'jpeg', 'gif', 'png' ])) {
            return $this->fail("Image Upload Failed", 400);
        }

        list(,$imageData)      = explode(',', $imageData);
        $fileName = uniqid().'.'.$extension;
        $imageData = base64_decode($imageData);
        file_put_contents(ROOTPATH.'public/uploads/products/'.$fileName, $imageData);


        $data['product_image'] = $fileName;

        $user  = $productModel->insert($data);
        if ($user === false) {
            return $this->fail($productModel->errors(), 400);
        }else{
            return $this->respondCreated($user);

        }
    }
    public function show($id = NULL)
    {
        if(!Auth::$IS_LOGIN){
            return $this->fail('Access denied', 401,'TYU7890');
        }
        $productModel = new ProductsModal();
        $service = $productModel->find($id);
        return $this->respond($service, 200);
    }

    public function delete($id = NULL)
    {
        if(!Auth::$IS_LOGIN){
            return $this->fail('Access denied', 401,'TYU7890');
        }
        $productModel = new ProductsModal();
        $service = $productModel->delete($id);
        return $this->respond($service, 200);
    }

    public function update($id = NULL)
    {
        if(!Auth::$IS_LOGIN){
            return $this->fail('Access denied', 401,'TYU7890');
        }
        $productModel = new ProductsModal();


        ///Getting Post Data
        $post = file_get_contents("php://input");
        $POST  =json_decode($post, true);
        $POST = $POST  ? $POST : $_POST;


        $data['product_name'] = isset($POST['product_name']) ? $POST['product_name'] : '';
        $data['product_short'] = isset($POST['product_short']) ? $POST['product_short'] : '';
        $data['product_long'] = isset($POST['product_long']) ? $POST['product_long'] : '';
        $data['product_discount_price'] = isset($POST['product_discount_price']) ? $POST['product_discount_price'] : '';
        $data['product_category'] = isset($POST['product_category']) ? $POST['product_category'] : '';
        $data['product_price'] = isset($POST['product_price']) ? $POST['product_price'] : '';
        if(isset($POST['product_status'])){
            $data['product_status'] =$POST['product_status'];
        }
        $imageData = isset($POST['product_image']) ? $POST['product_image'] : '';

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
            file_put_contents(ROOTPATH.'public/uploads/products/'.$fileName, $imageData);
            $data['product_image'] = $fileName;
        }
        
        $service = $productModel->update($id, $data);
        return $this->respond($service, 200);
    }

    public function filter($type = null)
    {
        if(!Auth::$IS_LOGIN){
            return $this->fail('Access denied', 401,'TYU7890');
        }
        $productModel = new ProductsModal();
        $user = $productModel->where('product_category', $type)->findAll();
        return $this->respond($user, 200);
    }
}
