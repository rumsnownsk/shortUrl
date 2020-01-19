<?php

namespace app\models;

use Illuminate\Database\Eloquent\Model;

class Urls extends Model
{
    protected $table = 'urls';

    protected $dateFormat = 'U';

    public $timestamps = false;

    protected $fillable = [
        'origin_url',
        'short_url',
        'ip_client',
        'user_agent'
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->created_at = $model->freshTimestamp();
        });
    }

    public function add($fields){
        $fields['short_url'] = $this->randomString();
        $fields['ip_client'] = $_SERVER['REMOTE_ADDR'];
        $fields['user_agent'] = $_SERVER['HTTP_USER_AGENT'];
        $model = new static;
        $model->fill($fields);
        $model->save();
        return $fields['short_url'];

    }

    public function randomString($length = 5) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}