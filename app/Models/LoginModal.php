<?php

namespace App\Models;

use CodeIgniter\Model;

class LoginModal extends Model
{

    protected $table = 'all_users';
    protected $primaryKey = 'rowid';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields = ['user_name', 'user_email','user_type','user_passowrd','user_token','user_address','user_address','user_note','user_image','store_id'];

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


    public function do_login($user, $password)
    {
        $db = \Config\Database::connect();
        $query = $db->query("SELECT rowid,user_type,user_passowrd FROM all_users WHERE user_email =  '{$user}'LIMIT 1");
        $row   = $query->getRow();
        if ($row) {
            if (password_verify($password, $row->user_passowrd)) {
                $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                $randstring = '';
                for ($i = 0; $i < 15; $i++) {
                    $randstring .= $characters[rand(0, strlen($characters) - 1)];
                }
                $builder = $db->table('all_users');
                $builder->set('login_token', $randstring);
                $builder->where('rowid', $row->rowid);
                $builder->update();
                return $randstring;
            }
        }
        return false;
    }

    public function myDetail($id)
    {
        $db = \Config\Database::connect();
        $query = $db->query("SELECT user_name,user_email,user_type FROM all_users WHERE rowid =  '{$id}'LIMIT 1");
        $row   = $query->getRow();
        if ($row) {
            return $row;
        }
        return false;
    }
}
