<?php

namespace app\api\controller;

use think\Controller;

header('Content-type:text/json');   

class Weather extends Controller
{
    public function read($cityCode = '101010100')
    {
      $url = 'http://t.weather.sojson.com/api/weather/city/'.$cityCode;
      $contents= file_get_contents($url);//获取页面内容
      $json = json_decode($contents, 1);//json_decode：把json变量变成php变量，括号里的1用于把json转化为数组
      //var_dump($json);//展开变量的结构并输出
      //$time=$json['time'];
      //$data="时间：".$time.'<br/>城市：'.$json['cityInfo']['city'];
      //echo $data;
      return json($json);
    }

}




