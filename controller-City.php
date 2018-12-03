<?php
//控制器，业务逻辑
namespace app\api\controller;

use think\Controller;

class City extends Controller
{
    public function read()
    {
        $cityName = input('county_name');
        $model = model('City');
        $data = $model->getNews($cityName);
        if ($data) {
            $code = 200;
        } else {
            $code = 404;
        }
        $data = [
            //'code' => $code,
            '城市编码：' => $data
        ];
        return json($data);
    }
}