<?php
namespace common\models;



use Yii;
use common\publics\MyHelper;
use backend\models\ArticleCollectionWebsite;
use common\publics\SimpleHtmlDom;
use common\publics\ImageUpload;

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
            ['sorts','default','value'=>999999],
            [['sorts','isRecommen','isPublish','titleImg','publishCode','publishTime','tags','search','imgCount','sourceLinke','imgProvider','remarks','leader','contentCount','source','ishot','url'],'safe']
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
    
    public function articles(array $data,$search = '')
    {
        $this->curPage = isset($data['curPage']) && !empty($data['curPage']) ? $data['curPage'] : $this->curPage;
        $query = $this->getQuery();
        if($this->load($search) && !empty($this->search)){
            $query = $this->queryFilter($this->search,$query);
        }

        return $this->query($query,$this->curPage,$this->pageSize);
    }
    
    
    public function getArticlesByExport($data)
    {
    	$query = $this->getQuery();
        
    	if($this->load($data) && !empty($this->search)){
    	    $query = $this->queryFilter($this->search,$query);
    	}

        $result = $query->asArray()->all();
        
        /* if(empty($result)){
        	return false;
        } */
        
        $phpExcel = new \PHPExcel();
        $objSheet = $phpExcel->getActiveSheet();
        $objSheet->getDefaultStyle()->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(\PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objSheet->setTitle('新闻列表');
        $objSheet->setCellValue('A1','序号')->setCellValue('B1','文章标题')->setCellValue('C1','文章作者')->setCellValue('D1','文章字数')
        ->setCellValue('E1','来源')->setCellValue('F1','来源链接')->setCellValue('G1','预览数')->setCellValue('H1','文章分类')->setCellValue('I1','发布时间')
        ->setCellValue('J1','是否发布')->setCellValue('K1','图片数')->setCellValue('L1','图片提供者')->setCellValue('M1','院领导')->setCellValue('N1','热点新闻')
        ->setCellValue('O1','创建时间')->setCellValue('P1','编辑时间')->setCellValue('Q1','备注');
        
        //设置填充的样式和背景色
        $colTitle = $objSheet->getStyle('A1:Q1');
        $colTitle->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID);
        $colTitle->getFill()->getStartColor()->setARGB('b6cad2');
        $colTitle->getFont()->setBold(true);
        $colTitle->getFont()->getColor()->setARGB(\PHPExcel_Style_Color::COLOR_WHITE);
        $colTitle->getFont()->setSize(12);
        
        //设置行高
        $objSheet->getDefaultRowDimension()->setRowHeight(24);
        //固定第一行
        $objSheet->freezePane('A2');
        
        //内容宽度
        $objSheet->getColumnDimension('A')->setWidth(8);
        $objSheet->getColumnDimension('B')->setWidth(80);
        $objSheet->getColumnDimension('C')->setWidth(25);
        $objSheet->getColumnDimension('D')->setWidth(15);
        $objSheet->getColumnDimension('E')->setWidth(50);
        $objSheet->getColumnDimension('F')->setWidth(50);
        $objSheet->getColumnDimension('G')->setWidth(8);
        $objSheet->getColumnDimension('H')->setWidth(15);
        $objSheet->getColumnDimension('I')->setWidth(20);
        $objSheet->getColumnDimension('J')->setWidth(15);
        $objSheet->getColumnDimension('K')->setWidth(8);
        $objSheet->getColumnDimension('L')->setWidth(15);
        $objSheet->getColumnDimension('M')->setWidth(15);
        $objSheet->getColumnDimension('N')->setWidth(8);
        $objSheet->getColumnDimension('O')->setWidth(20);
        $objSheet->getColumnDimension('P')->setWidth(20);
        $objSheet->getColumnDimension('Q')->setWidth(80);
        
        
        $num  = 2;
        foreach ($result as $article){
        	$objSheet->setCellValue('A'.$num,$article['id'])->setCellValue('B'.$num,$article['title'])->setCellValue('C'.$num,$article['author'])->setCellValue('D'.$num,$article['contentCount'])
        	->setCellValue('E'.$num,$article['source'])->setCellValue('F'.$num,$article['sourceLinke'])->setCellValue('G'.$num,$article['readCount'])->setCellValue('H'.$num,$article['categorys']['text'])
        	->setCellValue('I'.$num,MyHelper::timestampToDate($article['publishTime']))->setCellValue('J'.$num,$article['isPublish'] == 1?'已发布':'未发布')->setCellValue('K'.$num,$article['imgCount'])->setCellValue('L'.$num,$article['imgProvider'])
        	->setCellValue('M'.$num,$article['leader'])->setCellValue('N'.$num,$article['ishot']==1?'是':'否')
        	->setCellValue('O'.$num,MyHelper::timestampToDate($article['createTime']))->setCellValue('P'.$num,MyHelper::timestampToDate($article['modifyTime']))->setCellValue('Q'.$num,$article['remarks']);
        	$num ++;
        }
        $objWriter = \PHPExcel_IOFactory::createWriter($phpExcel,'Excel2007');
        ExcelMolde::exportBrowser('新闻列表.xlsx');
        $objWriter->save('php://output');

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
    
    private function getQuery()
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
    	        self::tableName().'.sorts',
    			self::tableName().'.createTime',
    			self::tableName().'.modifyTime',
    			self::tableName().'.remarks',
    	        self::tableName().'.isRecommen',
    	        self::tableName().'.titleImg'
    	])
    	->with('categorys')
    	->where([self::tableName().'.isDelete'=>0])
    	->orderBy('publishTime desc'); //2018-08-28 10:00:00后台新闻列表和前端新闻列表均按照发布时间进行排序，与其他因素无关。（取消现在的置顶、推荐、排序功能）；ishot desc,sorts asc,publishTime desc 又修改为按创建时间排序2018-08-27 16:25:00；
    	return $query;
    }
    
    private function queryFilter($search,$query)
    {
        if(!empty($search['keywords'])){
            $query = $query->andWhere(['or',['like','author',$search['keywords']],['like','title',$search['keywords']]]);
        }
        if(!empty($search['categoryId']) && $search['categoryId'] != 'unkown'){
            $query = $query->andWhere('categoryId = :categoryId',[':categoryId'=>$search['categoryId']]);
        }
        
        if(!empty($search['categoryIds'])){
            $query = $query->andWhere(['in','categoryId',$search['categoryIds']]);
        }
        
        if(isset($search['isPublish']) && is_numeric($search['isPublish'])){
            $query = $query->andWhere('isPublish = :isPublish',[':isPublish'=>$search['isPublish']]);
        }
        
        if(isset($search['isTitleImg']) && is_numeric($search['isTitleImg'])){
            if($search['isTitleImg'] == 0){
                $query = $query->andWhere("titleImg = ''");
            }else{
                $query = $query->andWhere("titleImg <> ''");
            }
        }
        
        if(!empty($search['imgProvider'])){
            $query = $query->andWhere(['like','imgProvider',$search['imgProvider']]);
        }
        if(!empty($search['publishStartTime'])){
            $query = $query->andWhere('publishTime >= :publishStartTime',[':publishStartTime'=>strtotime($search['publishStartTime'])]);
        }
        if(!empty($search['publishEndTime'])){
            $query = $query->andWhere('publishTime <= :publishEndTime',[':publishEndTime'=>strtotime($search['publishEndTime'])]);
        }
        return $query;
    }
    
    public function create(array $data)
    {
        $this->scenario = 'create';
        if($this->load($data) && $this->validate()){
            //如果选择了首页推荐   未上传新闻主题
            if($this->isRecommen == 1 && empty($_FILES['image'])){
                $this->addError('url','推荐首页的文章必须上传新闻主图');
                return false;
            }
            //先上传图片 再写数据
            if(isset($_FILES['image']) && !empty($_FILES['image']) && !empty($_FILES['image']['tmp_name']) ){
                
                $upload = new ImageUpload([
                    'imageMaxSize' => 1024*1024*500,
                    'isWatermark'  => false,
                    'imagePath'    => 'article'
                ]);
                $result = $upload->Upload('image');
                $imageName = Yii::$app->params['oss']['host'].$result;
                $this->titleImg = $imageName;
            }
            
            self::getPublishTime($this->publishCode,$this);
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
    
    public function edit(array $data,Article $article)
    {
        $article->scenario = 'edit';
        if($article->load($data) && $article->validate()){
            //如果选择了首页推荐   未上传新闻主题
            if($article->isRecommen == 1 && empty($article->titleImg) && empty($_FILES['image'])){
                $article->addError('url','推荐首页的文章必须上传新闻主图');
                return false;
            }
            //先上传图片 再写数据
            if(isset($_FILES['image']) && !empty($_FILES['image']) && !empty($_FILES['image']['tmp_name']) ){
                
                $upload = new ImageUpload([
                    'imageMaxSize' => 1024*1024*500,
                    'isWatermark'  => false,
                    'imagePath'    => 'article'
                ]);
                $result = $upload->Upload('image');
                $imageName = Yii::$app->params['oss']['host'].$result;
                if(!empty($article->titleImg)){
                    //删除旧的文件
                    $block = str_replace(Yii::$app->params['oss']['host'], '', $article->titleImg);
                    $upload->deleteImage($block);
                }
                $article->titleImg = $imageName;
            }
            self::getPublishTime($article->publishCode,$article);
            if($article->save(false)){
                return true;//self::batchAddArticleTags($this->tags,$this->id);
            };
        }
        return false;
    }
    
    private static function getPublishTime(string $publishCode,$obj)
    {
        switch ($publishCode){
            case 'now':
                $obj->isPublish  = 1;
                $obj->publishTime= TIMESTAMP;
                break;
            case 'min30':
                $obj->isPublish  = 0;
                $obj->publishTime= TIMESTAMP + 30 * 60;
                break;
            case 'oneHours':
                $obj->isPublish  = 0;
                $obj->publishTime= TIMESTAMP + 60 * 60;
                break;
            case 'oneDay':
                $obj->isPublish  = 0;
                $obj->publishTime= TIMESTAMP + 60 * 60 * 24;
                break;
            case 'userDefined':
                if(strtotime($obj->publishTime) <= time()){
                    $obj->isPublish  = 1;
                }else{
                    $obj->isPublish  = 0;
                }
                $obj->publishTime = strtotime($obj->publishTime);
                break;
            default:
                $obj->isPublish  = 0;
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