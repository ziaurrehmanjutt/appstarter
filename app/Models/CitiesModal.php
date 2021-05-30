<?php

namespace App\Models;

use CodeIgniter\Model;

class CitiesModal extends Model
{
    protected $table = 'all_cities';
    protected $primaryKey = 'rowid';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields = ['city_name', 'country_name','seller_id'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'delete_at';


    // protected $skipValidation     = false;

    protected $validationRules    = [
        'city_name'     => 'required|alpha_numeric_space|min_length[3]',
        'seller_id'  => 'required'
    ];

    protected $validationMessages = [
        'city_name'        => [
            'required' => 'City Name is Required',
            'min_length' => 'City name is Not So Good'
        ]
    ];
}
