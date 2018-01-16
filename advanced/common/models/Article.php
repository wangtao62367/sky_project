<?php
namespace common\models;




use common\publics\MyHelper;
use yii\base\Exception;
use backend\models\ArticleCollectionWebsite;

class Article extends BaseModel
{
    public $tags;
    
    
    
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
            [['isPublish','tags','search','imgCount'],'safe']
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
    
    
    public function articles(array $get,array $search)
    {
        $this->curPage = isset($get['curPage']) && !empty($get['curPage']) ? $get['curPage'] : $this->curPage;
        $query = self::find()
                ->with(['articletags'=>function(\yii\db\ActiveQuery $query){
                    $query->with(['tags']);
                }])
                ->with('categorys')
               ->where(['isDelete'=>0])
               ->orderBy('modifyTime desc');
        if (!empty($search) && $this->load($search)){
            if(!empty($this->search['keywords'])){
                $query = $query->andWhere(['or',['like','author',$this->search['keywords']],['like','title',$this->search['keywords']]]);
            }
            if(!empty($this->search['categoryId']) && $this->search['categoryId'] != 'unkown'){
                $query = $query->andWhere('categoryId = :categoryId',[':categoryId'=>$this->search['categoryId']]);
            }
            if(!empty($this->search['isPublish']) && $this->search['isPublish'] != 'unkown'){
                $query = $query->andWhere('isPublish = :isPublish',[':isPublish'=>$this->search['isPublish']]);
            }
        }
        return $this->query($query,$this->curPage,$this->pageSize);
    }
    
    public function create(array $data)
    {
        $this->scenario = 'create';
        if($this->load($data) && $this->validate()){
            if($this->save(false)){
               return true;//self::batchAddArticleTags($this->tags,$this->id);
            };
            
        }
        return false;
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

        //取出div标签且id為PostContent的內容，並储存至阵列match
        preg_match($contentPreg,$text,$match);

        //获取字符串编码
        $encode = mb_detect_encoding($match[1], array("ASCII",'UTF-8',"GB2312","GBK",'BIG5'));
        //将字符编码改为utf-8
        $str_encode = mb_convert_encoding($match[1], 'UTF-8', $encode);
        return [
            'success' => true,
            'message' => '请求成功',
            'data'    => $str_encode
        ];
    }
    
    
}