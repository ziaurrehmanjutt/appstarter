<?php

namespace App\Models;

use CodeIgniter\Model;

class LoginModal extends Model
{
   public function do_login($user,$password){
    $db = \Config\Database::connect();
    $query = $db->query("SELECT rowid,user_type,user_passowrd FROM all_users WHERE user_email =  '{$user}'LIMIT 1");
    $row   = $query->getRow();
    if($row){
         if(password_verify($password, $row->user_passowrd)){
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $randstring = '';
            for ($i = 0; $i < 15; $i++) {
                $randstring .= $characters[rand(0, strlen($characters)-1)];
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
}
