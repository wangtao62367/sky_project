<?php
namespace backend\models;



class ArticleCollectionWebsite
{
    //人民网
    const PEOPLE_COM_CN = 'people.com.cn';
    //新华网
    const XINHUANET_COM = 'xinhuanet.com';
    //中央社会主义网
    const ZYSY_ORG_CN   = 'zysy.org.cn';
    //四川省委组织部
    const GCDR_GOV_CN   = 'gcdr.gov.cn';
    
    public static $conllectWebsiteArr = [
        'people.com.cn'=>'div#rwb_zw',//'/<div[^>]*id="rwb_zw"[^>]*>(.*?)<div class="zdfy clearfix">/si',
        'xinhuanet.com'=>'div#p-detail',//'/<div[^>]*id="p-detail"[^>]*>(.*?)<\/div>/si',
        'zysy.org.cn'  =>'div.content_con',//'/<div[^>]*class="content_con"[^>]*>(.*?)<\/div>/si',
        'gcdr.gov.cn'  =>'div.content'//'/<div[^>]*class="content"[^>]*>(.*?)<\/div>/si'
    ];
    
    
    public static $conllectWebsiteArrText = [
        'people.com.cn'=>'人民网',//'/<div[^>]*id="rwb_zw"[^>]*>(.*?)<div class="zdfy clearfix">/si',
        'xinhuanet.com'=>'新华网',//'/<div[^>]*id="p-detail"[^>]*>(.*?)<\/div>/si',
        'zysy.org.cn'  =>'中央社会主义学院网',//'/<div[^>]*class="content_con"[^>]*>(.*?)<\/div>/si',
        'gcdr.gov.cn'  =>'四川省委组织部'//'/<div[^>]*class="content"[^>]*>(.*?)<\/div>/si'
    ];
}