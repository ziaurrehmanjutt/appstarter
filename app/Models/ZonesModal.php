<?php

namespace App\Models;

use CodeIgniter\Model;

class ZonesModal extends Model
{
    protected $table = 'all_zones';
    protected $primaryKey = 'rowid';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields = [ 'zone_name', 'zone_descriptions', 'zone_address', 'zone_lat', 'zone_lng', 'zone_seller','zone_city'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'delete_at';


    // protected $skipValidation     = false;

    protected $validationRules    = [
        'zone_name'     => 'required|alpha_numeric_space|min_length[3]',
        'zone_seller'  => 'required',
        'zone_city'  => 'required'
    ];

    protected $validationMessages = [
        'zone_name'        => [
            'required' => 'Zone Name is Required',
            'min_length' => 'Zone name is Not So Good'
        ]
    ];
}
