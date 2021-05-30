<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductsModal extends Model
{
    protected $table = 'all_products';
    protected $primaryKey = 'rowid';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields = ['product_name', 'product_short','product_long','product_image','product_price','product_discount_price','product_category','product_seller','product_quantity','product_status'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'delete_at';


    // protected $skipValidation     = false;

    protected $validationRules    = [
        'product_name'     => 'required|alpha_numeric_space|min_length[3]',
        'product_short'        => 'required',
        'product_image'        => 'required',
        'product_price'        => 'required',
        'product_category'        => 'required',
    ];

    protected $validationMessages = [
        'product_name'        => [
            'required' => 'Product Name is Required',
            'min_length' => 'Product name is Not So Good'
        ]
    ];
}
