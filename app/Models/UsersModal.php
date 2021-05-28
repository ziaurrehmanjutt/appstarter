<?php

namespace App\Models;

use CodeIgniter\Model;

class UsersModal extends Model
{
    protected $table = 'all_users';
    protected $primaryKey = 'rowid';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields = ['user_name', 'user_email','user_type','user_passowrd','user_token','user_address','user_address','user_note','user_image'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'update_at';
    protected $deletedField  = 'delate_at';


    // protected $skipValidation     = false;

    protected $validationRules    = [
        'user_name'     => 'required|alpha_numeric_space|min_length[3]',
        'user_email'        => 'required|valid_email|is_unique[all_users.user_email]',
        'user_type'        => 'required',
        'user_passowrd'        => 'required|min_length[6]',
    ];

    protected $validationMessages = [
        'user_email'        => [
            'is_unique' => 'Sorry. That email has already been taken. Please choose another.'
        ]
    ];
}
