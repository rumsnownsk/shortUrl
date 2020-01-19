<?php

namespace app\controllers;

use app\models\Urls;
use Illuminate\Database\Capsule\Manager as DB;


class MainController extends CommonController
{
    public function indexAction()
    {
        $this->render('index');
    }

    public function shortLinkAjaxAction(){
        if (!$this->isAjax()){
            redirect('/');
        }
        $model = new Urls();

        $find = $model->where('origin_url', $_POST['origin_url'])->first();

        if ($find){
            echo json_encode([
                'code' => 200,
                'shortlink' => 'short-url.ru/'.$find->short_url
            ], JSON_UNESCAPED_UNICODE);die;

        }
        $new = $model->add($_POST);

        if($new){
            $data = [
                'code' => 200,
                'shortlink' => 'short-url.ru/'.$new
            ];
        } else {
            $data = [
                'code' => 500,
                'shortlink' => ''
            ];
        };

        echo json_encode($data, JSON_UNESCAPED_UNICODE);die;
    }

    public function getOrigLinkAction($link){
        $res = DB::table('urls')->where('short_url', $link)->first();
        redirect($res->origin_url);
    }

}