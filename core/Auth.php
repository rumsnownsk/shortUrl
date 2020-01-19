<?php

namespace core;


use app\models\User;
use Illuminate\Database\Eloquent\Model;

class Auth
{
    public $id;
    public $username;
    public $email;
    public $role;
    public $fio;

    public static $errors = array();

    public static function login(){
        $username = !empty(trim($_POST['username'])) ? trim($_POST['username']) : null;
        $password = !empty(trim($_POST['password'])) ? trim($_POST['password']) : null;


        if ($username && $password){

            $user = User::where('username', $username)->first();

            if($user && password_verify($password, $user->password)){

                if (isset($_POST['rememberme'])){
                    $password_cookie_token = md5($user->id.$password.time());
                    $user->password_cookie_token = $password_cookie_token;
                    $user->save();

                    setcookie('password_cookie_token', $password_cookie_token, time()+60*60*24*30, '/');

                } else{
                    $user->password_cookie_token = '';
                    $user->save();
                    setcookie('password_cookie_token', '', time()-3600*24*30*12, '/');
                }

                $_SESSION['auth'] = $user->attributesToArray();

//                self::$levelAccess = $user['role'];

                return true;
            };
            self::$errors[]['auth'] = 'Такой пользователь не найден';
            return false;
        }
        self::$errors[]['auth'] = 'Необходимо ввести логин и пароль';
        return false;
    }

    public static function getErrors(){
        $errors = [];
        foreach (self::$errors as $error) {
            foreach ($error as $item) {
                $errors[] .= $item;
            }
        }
        return $errors;
    }

    public static function isLogin(){
        if(isset($_SESSION['auth'])){
            return true;
        } else return false;
    }

    public static function levelAccess(){
        return $_SESSION['auth']['role'];
    }

    public static function isAdmin(){
        if (isset($_SESSION['auth']) && $_SESSION['auth']['role'] == 0){
            return true;
        } else return false;
    }

    public function setAttributes($data){
        $this->id = $data['id'];
        $this->username = $data['username'];
        $this->email = $data['email'];
        $this->role = $data['role'];
        $this->fio = $data['fio'];
    }


}