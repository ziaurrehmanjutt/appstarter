<?php

namespace App\Models;

use CodeIgniter\Model;

class Auth extends Model
{
    protected $table = 'news';
    public static $TOKEN;
    public static $USER_ID;
    public static $USER_TYPE;
    public static $IS_LOGIN;

    public static function do_login($token){
        $db = \Config\Database::connect();
        $query = $db->query("SELECT rowid,user_type FROM all_users WHERE login_token =  '{$token}'LIMIT 1");
        $row   = $query->getRow();
        if($row){
            self::$IS_LOGIN =  TRUE;
            self::$USER_ID =  $row->rowid;
            self::$USER_TYPE =  $row->user_type;
        }
    }

    public function login(){
       
    }
}
