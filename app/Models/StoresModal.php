<?php

namespace App\Models;

use CodeIgniter\Model;

class StoresModal extends Model
{
    protected $table = 'all_stores';
    protected $primaryKey = 'rowid';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields = ['store_name', 'store_description', 'store_address', 'store_city', 'store_zone', 'stor_lat', 'store_lng', 'store_status', 'store_admin','store_image','store_banner'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'delete_at';


    // protected $skipValidation     = false;

    protected $validationRules    = [
        'store_name'     => 'required|alpha_numeric_space|min_length[3]'
    ];

    protected $validationMessages = [
        'store_name'        => [
            'required' => 'Store Name is Required',
            'min_length' => 'Store name is Not So Good'
        ]
    ];
}
