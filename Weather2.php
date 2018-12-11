<?php
//获得参数 signature nonce token timestamp echostr
    $nonce     = $_GET['nonce'];
    $token     = 'wwr1996';
    $timestamp = $_GET['timestamp'];
    $echostr   = $_GET['echostr'];
    $signature = $_GET['signature'];
    //形成数组，然后按字典序排序
    $array = array();
    $array = array($nonce, $timestamp, $token);
    sort($array);
    //拼接成字符串,sha1加密 ，然后与signature进行校验
    $str = sha1( implode( $array ) );
    if( $str == $signature && $echostr ){
        //第一次接入weixin api接口的时候
        echo  $echostr;
        exit;
    }
	else{
       //1.获取到微信推送过来post数据（xml格式）
        $postArr = $GLOBALS['HTTP_RAW_POST_DATA'];
        //2.处理消息类型，并设置回复类型和内容
        $postObj = simplexml_load_string( $postArr );
        //判断该数据包是否是订阅的事件推送
        if( strtolower( $postObj->MsgType) == 'event'){
            //如果是关注 subscribe 事件
            if( strtolower($postObj->Event == 'subscribe') ){
                //回复用户消息(纯文本格式)
                $toUser   = $postObj->FromUserName;
                $fromUser = $postObj->ToUserName;
                $time     = time();
                $msgType  =  'text';
                $content  = '欢迎关注我们的微信公众账号，此公众号为测试公众号！'.$postObj->FromUserName.'-'.$postObj->ToUserName;
                $template = "<xml>
                                <ToUserName><![CDATA[%s]]></ToUserName>
                                <FromUserName><![CDATA[%s]]></FromUserName>
                                <CreateTime>%s</CreateTime>
                                <MsgType><![CDATA[%s]]></MsgType>
                                <Content><![CDATA[%s]]></Content>
                                </xml>";
                $info     = sprintf($template, $toUser, $fromUser, $time, $msgType, $content);
                echo $info;
            }
        }
    }

		//发送文本的响应
      	if(strtolower($postObj -> MsgType) == 'text'){
          //接受文本信息
          $content = $postObj -> Content;
          //回复用户消息（纯文本格式）
          $toUser = $postObj -> FromUserName;
          $fromUser = $postObj -> ToUserName;
          $time = time();
          $msgType = 'text';
          
          //天气
		  $str = mb_substr($content,-2,2,"UTF-8");//从后两个字符开始取，读两个
		  $str_key = mb_substr($content,0,-2,"UTF-8");//
          if($str == '天气'  && !empty($str_key)){
            $content = "【".$content."预报】\n"."2018年11月26日 15时实时发布\n\n实时天气\n晴 0°C~8°C 南风5-6级\n\n温馨提示：天气很冷，建议穿羽绒服啊，围巾帽子啥的都要带啊，穿厚裤子注意保暖啊，不但冻僵硬了啊，就算被衣服包裹成一只肥球，咱帅羊公众号也不会嘲笑你的~\n\n明天\n晴 2°C~9°C 北风1-2级\n\n后天\n晴转多云 -1°C~5°C 西风6-7级";
          }
          else{
          $content = '您发送的内容是：'.$content;
          }
          $template = "<xml>
                                <ToUserName><![CDATA[%s]]></ToUserName>
                                <FromUserName><![CDATA[%s]]></FromUserName>
                                <CreateTime>%s</CreateTime>
                                <MsgType><![CDATA[%s]]></MsgType>
                                <Content><![CDATA[%s]]></Content>
                                </xml>";
          $info     = sprintf($template, $toUser, $fromUser, $time, $msgType, $content);
                echo $info;
        }