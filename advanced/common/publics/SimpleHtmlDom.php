<?php
namespace common\publics;



class SimpleHtmlDom
{
    public function __construct(){
        include  dirname(__FILE__) .'/simplehtmldom/simple_html_dom.php';
    }
    
    public function getFileHtml($url)
    {
        return file_get_html($url);
    }
    
    public function getStrHtml($str)
    {
        return str_get_html($str);
    }
}