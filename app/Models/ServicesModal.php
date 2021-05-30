<?php

namespace App\Models;

use CodeIgniter\Model;

class ServicesModal extends Model
{
    protected $table = 'all_services';
    protected $primaryKey = 'rowid';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields = ['service_name', 'service_descriptions','service_image','service_seller'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'delete_at';


    // protected $skipValidation     = false;

    protected $validationRules    = [
        'service_name'     => 'required|alpha_numeric_space|min_length[3]'
    ];

    protected $validationMessages = [
        'service_name'        => [
            'required' => 'Service Name is Required',
            'min_length' => 'Service name is Not So Good'
        ]
    ];
}
