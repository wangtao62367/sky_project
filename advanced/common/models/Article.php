<?php
namespace common\models;




use common\publics\MyHelper;
use yii\base\Exception;
use backend\models\ArticleCollectionWebsite;
use common\publics\SimpleHtmlDom;
use yii\helpers\ArrayHelper;

class Article extends BaseModel
{
    public $tags;
    
    public $publishTimeArr = [
        'now' => '立即发布',
        'min30' =>'30分钟后',
        'oneHours' => '1小时候',
        'oneDay' => '1天以后',
        'nopublish' => '暂不发布',
        'userDefined' => '自定义'
    ];
    
    
    public static function tableName()
    {
        return '{{%Article}}';
    }
    
    public function rules()
    {
        return [
            ['title','required','message'=>'文章标题不能为空','on'=>['create','edit']],
            ['author','required','message'=>'文章作者不能为空','on'=>['create','edit']],
            ['summary','required','message'=>'文章摘要不能为空','on'=>['create','edit']],
            ['content','required','message'=>'文章内容不能为空','on'=>['create','edit']],
            ['categoryId','required','message'=>'文章分类不能为空','on'=>['create','edit']],
            [['isPublish','publishCode','publishTime','tags','search','imgCount','sourceLinke','imgProvider','remarks','leader','contentCount','source','ishot','url'],'safe']
        ];
    }
    
    public function getArticletags()
    {
        return $this->hasMany(ArticleTag::className(), ['articleId'=>'id']);
    }
    
    public function getCategorys()
    {
        return $this->hasOne(Category::className(), ['id'=>'categoryId']);
    }
    
    public function articles(array $data,array $search)
    {
        $this->curPage = isset($data['curPage']) && !empty($data['curPage']) ? $data['curPage'] : $this->curPage;
        $query = self::find()
                ->with(['articletags'=>function(\yii\db\ActiveQuery $query){
                    $query->with(['tags']);
                }])
                ->with('categorys')
               ->where(['isDelete'=>0])
               ->orderBy('modifyTime desc');
        if (!empty($search) && $this->load($search)){
            $query = $this->queryFilter($data,$query);
        }
        return $this->query($query,$this->curPage,$this->pageSize);
    }
    
    public function getArticlesByExport($data)
    {
        $query = self::find()
            ->select([
                self::tableName().'.id',
                self::tableName().'.title',
                self::tableName().'.url',
                self::tableName().'.author',
                self::tableName().'.contentCount',
                self::tableName().'.source',
                self::tableName().'.sourceLinke',
                self::tableName().'.readCount',
                self::tableName().'.categoryId',
                self::tableName().'.publishTime',
                self::tableName().'.isPublish',
                self::tableName().'.imgCount',
                self::tableName().'.imgProvider',
                self::tableName().'.leader',
                self::tableName().'.ishot',
                self::tableName().'.createTime',
                self::tableName().'.modifyTime',
                self::tableName().'.remarks',
            ])
            ->with('categorys')
            ->where([self::tableName().'.isDelete'=>0])
            ->orderBy('ishot desc,modifyTime desc');
        if (!empty($data) && $this->load($data)){
            $query = $this->queryFilter($data,$query);
        }
        $result = $query->asArray()->all();
        
        $phpExcel = new \PHPExcel();
        $objSheet = $phpExcel->getActiveSheet();
        $objSheet->setTitle('社会主义新闻列表');
        $objSheet->setCellValue('A1','序号')->setCellValue('B1','文章标题')->setCellValue('C1','文章作者')->setCellValue('D1','文章字数')
        ->setCellValue('E1','来源')->setCellValue('F1','来源链接')->setCellValue('G1','预览数')->setCellValue('H1','文章分类')->setCellValue('I1','发布时间')
        ->setCellValue('J1','是否发布')->setCellValue('K1','图片数')->setCellValue('L1','图片提供者')->setCellValue('M1','院领导')->setCellValue('N1','热点新闻')
        ->setCellValue('O1','创建时间')->setCellValue('P1','修改时间')->setCellValue('Q1','备注');
        $cell = 'A';
        $num  = '1';
        foreach ($result as $article){
            foreach ($article as $v){
                $objSheet->setCellValue($cell.$num,'姓名')->setCellValue('B1','分数');
            }
        }
        $objSheet->setCellValue('A1','姓名')->setCellValue('B1','分数');
        $objSheet->setCellValue('A2','张三')->setCellValue('B2','89');
        
        $objWriter = \PHPExcel_IOFactory::createWriter($phpExcel,'Excel2007');
        
        $this->exportBrowser('demo.xlsx');
        $objWriter->save('php://output');
        
        return $result;
    }
    
    public function attributeLabels()
    {
        return [
            'id' => '序号',
            'title' => '文章标题',
            'url'   => '文章超链接',
            'author' => '文章作者',
            'contentCount' => '文章字数',
            'source' => '来源',
            'sourceLinke' => '来源链接',
            'readCount' => '预览数',
            'categoryId' => '分类ID',
            'publishTime' => '发布时间',
            'isPublish' => '是否发布',
            'imgCount'  => '图片数',
            'imgProvider' => '图片提供者',
            'leader' => '院领导',
            'ishot'  => '热点新闻',
            'createTime' => '创建时间',
            'modifyTime' => '编辑时间',
            'remarks' => '备注'
            
        ];
    }
    
    private function queryFilter($data,$query)
    {
        if (!empty($data) && $this->load($data)){
            if(!empty($this->search['keywords'])){
                $query = $query->andWhere(['or',['like','author',$this->search['keywords']],['like','title',$this->search['keywords']]]);
            }
            if(!empty($this->search['categoryId']) && $this->search['categoryId'] != 'unkown'){
                $query = $query->andWhere('categoryId = :categoryId',[':categoryId'=>$this->search['categoryId']]);
            }
            if(!empty($this->search['isPublish']) && $this->search['isPublish'] != 'unkown'){
                $query = $query->andWhere('isPublish = :isPublish',[':isPublish'=>$this->search['isPublish']]);
            }
            if(!empty($this->search['imgProvider'])){
                $query = $query->andWhere(['like','imgProvider',$this->search['imgProvider']]);
            }
            if(!empty($this->search['publishStartTime'])){
                $query = $query->andWhere('publishTime >= :publishTime',[':publishTime'=>strtotime($this->search['publishStartTime'])]);
            }
            if(!empty($this->search['publishEndTime'])){
                $query = $query->andWhere('publishTime <= :publishTime',[':publishTime'=>strtotime($this->search['publishEndTime'])]);
            }
        }
        return $query;
    }
    
    public function create(array $data)
    {
        $this->scenario = 'create';
        if($this->load($data) && $this->validate()){
            $this->getPublishTime($this->publishCode);
            if(!empty($this->url)){
                if(!MyHelper::urlIsValid($this->url)){
                    $this->addError('url','文章超链接地址无效');
                    return false;
                }
            }
            if($this->save(false)){
               return true;//self::batchAddArticleTags($this->tags,$this->id);
            };
            
        }
        return false;
    }
    
    private function getPublishTime(string $publishCode)
    {
        switch ($publishCode){
            case 'now':
                $this->isPublish  = 1;
                $this->publishTime= TIMESTAMP;
                break;
            case 'min30':
                $this->isPublish  = 0;
                $this->publishTime= TIMESTAMP + 30 * 60;
                break;
            case 'oneHours':
                $this->isPublish  = 0;
                $this->publishTime= TIMESTAMP + 60 * 60;
                break;
            case 'oneDay':
                $this->isPublish  = 0;
                $this->publishTime= TIMESTAMP + 60 * 60 * 24;
                break;
            case 'userDefined':
                $this->isPublish  = 0;
                $this->publishTime = strtotime($this->publishTime);
                break;
            default:
                $this->isPublish  = 0;
                break;
        }
    }
    
    public static function del(Article $article)
    {
        $article->isDelete = 1;
        return $article->save(false);
    }
    
    public static function conllectContent($sourceLinke)
    {
        $sourceLinke = urldecode($sourceLinke);
        if(!MyHelper::urlIsValid($sourceLinke)){
            return [
                'success' => false,
                'message' => '无效的地址',
                'data'    => ''
            ];
        }
        //验证是否是本系统允许抓取的网站网站链接
        $isValid = false;
        $contentPreg= '';
        foreach (ArticleCollectionWebsite::$conllectWebsiteArr as $key=>$link){
            if(strpos($sourceLinke,$key) !== false){
                $isValid = true;
                $contentPreg = $link;
                break;
            }
        }
        if(!$isValid){
            return [
                'success' => false,
                'message' => '地址来源必须是人民网、新华网、中央社会主义学院和四川组工网',
                'data'    => ''
            ];
        }
        $result = MyHelper::httpGet($sourceLinke);
        
         //去除換行及空白字元（序列化內容才需使用）
        $text=str_replace(array("\r","\n","\t","\s"), '', $result);

        //取出div标签的內容，並储存至阵列match
        preg_match($contentPreg,$text,$match);

        //获取字符串编码
        $encode = mb_detect_encoding($match[0], array("ASCII",'UTF-8',"GB2312","GBK",'BIG5'));
        //将字符编码改为utf-8
        $str_encode = mb_convert_encoding($match[0], 'UTF-8', $encode);
        return [
            'success' => true,
            'message' => '请求成功',
            'data'    => $str_encode
        ];
    }
    
    public static function conllectDivContent($sourceLinke = '')
    {
        $sourceLinke = urldecode($sourceLinke);
        if(!MyHelper::urlIsValid($sourceLinke)){
            return [
                'success' => false,
                'message' => '无效的地址',
                'data'    => ''
            ];
        }
        //验证是否是本系统允许抓取的网站网站链接
        $isValid = false;
        $contentPreg= '';
        $contentKey = '';
        foreach (ArticleCollectionWebsite::$conllectWebsiteArr as $key=>$link){
            if(strpos($sourceLinke,$key) !== false){
                $isValid = true;
                $contentPreg = $link;
                $contentKey  = $key;
                break;
            }
        }
        if(!$isValid){
            return [
                'success' => false,
                'message' => '地址来源必须是人民网、新华网、中央社会主义学院和四川组工网',
                'data'    => ''
            ];
        }
       // $sourceLinke = 'http://www.xinhuanet.com/politics/2018-01/16/c_1122268460.htm';
        $result = MyHelper::httpGet($sourceLinke);
        
        $dom = new SimpleHtmlDom();
        $html = $dom->getStrHtml($result);
        $el = $html->find($contentPreg,0);
        
        //获取字符串编码
        $encode = mb_detect_encoding($el->innertext, array("ASCII",'UTF-8',"GB2312","GBK",'BIG5'));
        //将字符编码改为utf-8
        $str_encode = mb_convert_encoding($el->innertext, 'UTF-8', $encode);
        return [
            'success' => true,
            'message' => '请求成功',
            'data'    => $str_encode,
            'source'  => ArticleCollectionWebsite::$conllectWebsiteArrText[$contentKey]
        ];
        
        echo '<pre>';
        print_r($el);
        // print_r(htmlspecialchars($str));
        echo '</pre>';
    }
    
    
}