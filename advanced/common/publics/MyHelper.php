<?php
namespace common\publics;


use common\models\QuestCategory;

class MyHelper 
{
    
    /**
    * 把数字1-1亿换成汉字表述，如：123->一百二十三
    * @param [num] $num [数字]
    * @return [string] [string]
    */
    public static function numToWord($num)
    {
        $chiNum = array('零', '一', '二', '三', '四', '五', '六', '七', '八', '九');
        $chiUni = array('','十', '百', '千', '万', '亿', '十', '百', '千');
        
        $chiStr = '';
        
        $num_str = (string)$num;
        
        $count = strlen($num_str);
        $last_flag = true; //上一个 是否为0
        $zero_flag = true; //是否第一个
        $temp_num = null; //临时数字
        
        $chiStr = '';//拼接结果
        if ($count == 2) {//两位数
            $temp_num = $num_str[0];
            $chiStr = $temp_num == 1 ? $chiUni[1] : $chiNum[$temp_num].$chiUni[1];
            $temp_num = $num_str[1];
            $chiStr .= $temp_num == 0 ? '' : $chiNum[$temp_num];
        }else if($count > 2){
            $index = 0;
            for ($i=$count-1; $i >= 0 ; $i--) {
                $temp_num = $num_str[$i];
                if ($temp_num == 0) {
                    if (!$zero_flag && !$last_flag ) {
                        $chiStr = $chiNum[$temp_num]. $chiStr;
                        $last_flag = true;
                    }
                }else{
                    $chiStr = $chiNum[$temp_num].$chiUni[$index%9] .$chiStr;
                    
                    $zero_flag = false;
                    $last_flag = false;
                }
                $index ++;
            }
        }else{
            $chiStr = $chiNum[$num_str[0]];
        }
        return $chiStr;
    }
    
    public static function toRate(int $num,int $total)
    {
        if($num == 0 || $total == 0){
            return '0%';
        }
        return round(($num / $total) * 100 ,2 ) . '%';
    }
    
    
    public static function timestampToDate($timestamp,$format = 'Y-m-d H:i:s')
    {
        return date($format,$timestamp);
    }
    
    
    public static function emailIsValid(string $email)
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }
    
    public static function phoneIsValid(string $phone)
    {
        return (bool)preg_match('/^[1][34578][0-9]{9}$/', $phone);
    }
    
    public static function urlIsValid($url)
    {
        return filter_var($url,FILTER_VALIDATE_URL);
    }
    
    
    
    /**
     * post请求
     * @param unknown $url
     * @param unknown $data
     */
    public static function httpPost($url,$data,$http = 'http',$header="Accept-Charset: utf-8")
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        //如果用的协议是https
        if($http == 'https'){
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        }
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        //curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_close ($ch);
        $tmpInfo = curl_exec($ch);
        if (curl_errno($ch)) {
            return false;
        }
        return $tmpInfo;
        
        
    }
    /**
     * get请求
     * @param string $url
     * @param string $http
     * @return mixed
     */
    public static function httpGet($url,$http = 'http')
    {
        $ch= curl_init ();
        curl_setopt ( $ch, CURLOPT_URL, $url );
        curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
        // curl_setopt ( $ch, CURLOPT_TIMEOUT, 500 );
        // curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/51.0.2704.106 Safari/537.36');
        
        //如果用的协议是https
        if($http == 'https'){
            curl_setopt ( $ch, CURLOPT_SSL_VERIFYPEER, false );
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        }
        $out = curl_exec ( $ch);
        curl_close ( $ch);
        return $out;
    }
    
    
    public static function getOpt($index,$cate)
    {
    	if($cate == QuestCategory::QUEST_RADIO || $cate == QuestCategory::QUEST_MULTI){
	    	$opts=range('A', 'Z');
	    	
    	}elseif ($cate == QuestCategory::QUEST_TRUEORFALSE){
    		$opts = ['正确','错误'];
    	}
    	return $opts[$index];  
    }
    
   
}