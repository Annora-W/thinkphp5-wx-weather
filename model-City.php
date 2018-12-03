<?php
namespace app\api\model;

use think\Model;
use think\Db;

//模型，访问数据库
class City extends Model
{
    public function getNews($cityName = '北京')
    {
        $res = Db::name('ins_county')->where('county_name', $cityName)->value('weather_code');//->select();
        return $res;
    }

    public function getNewsList()
    {
        $res = Db::name('ins_county')->select();
        return $res;
    }
}