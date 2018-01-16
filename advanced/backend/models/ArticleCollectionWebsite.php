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
        'people.com.cn'=>'/<div[^>]*id="rwb_zw"[^>]*>(.*?)<div class="zdfy clearfix">/',
        'xinhuanet.com'=>'/<div[^>]*id="p-detail"[^>]*>(.*?)<\/div>/si',
        'zysy.org.cn'  =>'/<div[^>]*class="content_con"[^>]*>(.*?)<\/div>/si',
        'gcdr.gov.cn'  =>'/<div[^>]*class="content"[^>]*>(.*?)<\/div>/si'
    ];
}