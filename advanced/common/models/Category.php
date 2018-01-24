<?php
namespace common\models;

use yii\db\Expression;
use common\publics\MyHelper;

/**
 * 文章分类
 * @author wangtao by 2017-11-27
 *
 */
class Category extends BaseModel
{
    public  $position_arr = [
        'normal' => '通用区',
        'top' => '顶部区',
        'hot' => '焦点区',
    ];
    
    public static $type_arr = [
        CategoryType::ARTICLE => '文章',
        CategoryType::IMAGE   => '图片',
        CategoryType::VIDEO   => '视频',
        CategoryType::FILE    => '文件'
    ];
    
    public static function tableName()
    {
        return '{{%Category}}';
    }
    
    public function rules()
    {
        return [
            ['text','required','message'=>'分类名称不能为空','on'=>['create','edit']],
            ['type','required','message'=>'分类类型不能为空','on'=>['create','edit']],
            ['parentId','required','message'=>'分类所属模块不能为空','on'=>['create','edit']],
            [['descr','positions','search'],'safe'],
        ];
    }
    
    public function create(array $data)
    {
        $this->scenario = 'create';
        if($this->load($data) && $this->validate()){
            return $this->save(false);
        }
        return false;
    }
    
    public static function edit(array $data , Category $cate)
    {
        $cate->scenario = 'edit';
        if($cate->load($data) && $cate->validate() && $cate->save(false)){
            return true;
        }
        return false;
    }
    
    public function getParents()
    {
        return $this->hasOne(Common::className(), ['id'=>'parentId']);
    }
    
    public function categoris(array $data)
    {
        $this->curPage = isset($data['curPage']) ? $data['curPage'] : $this->curPage;
        $query = $this->getQuery();
        $query = $this->filterSearch($data, $query);
        
        return $this->query($query,$this->curPage,$this->pageSize);

    }
    
    private function getQuery()
    {
    	$ext = 'CASE WHEN '.self::tableName().'.type = \''.CategoryType::ARTICLE.'\' then \'文章\'
                     WHEN '.self::tableName().'.type = \''.CategoryType::IMAGE.'\' then \'图片\'
                     WHEN '.self::tableName().'.type = \''.CategoryType::VIDEO.'\' then \'视频\'
                     WHEN '.self::tableName().'.type = \''.CategoryType::FILE.'\' then \'文件\'
                     ELSE \'未知\' END AS type_text';
    	$query = self::find()
    	->select([
    			self::tableName().'.id',
    			'text',
    			self::tableName().'.type',
    			new Expression($ext),
    			'descr',
    			'parentId',
    			'createTime',
    			'modifyTime',
    			'isBase',
    			Common::tableName().'.id as catParentId',
    			Common::tableName().'.code',
    			Common::tableName().'.codeDesc',
    	])
    	->joinWith('parents')
    	->where(['isDelete'=> 0,Common::tableName().'.type'=>'navigation'])
    	->orderBy(self::tableName().'.createTime desc');
    	return $query;
    }
    
    private function filterSearch($data,$query)
    {
    	if(!empty($data) && $this->load($data)){
    		if(!empty($this->search['text'])){
    			$query = $query->andWhere(['like','text',$this->search['text']]);
    		}
    		if(!empty($this->search['parentId']) && $this->search['parentId'] != 'unknow'){
    			$query = $query->andWhere(['parentId'=>$this->search['parentId']]);
    		}
    		if(!empty($this->search['type']) && $this->search['type'] != 'unknow'){
    			$query = $query->andWhere([self::tableName().'.type'=>$this->search['type']]);
    		}
    	}
    	return $query;
    }
    
    public function export($data)
    {
    	$query = $this->getQuery();
    	$query = $this->filterSearch($data, $query);;
    	$result = $query->all();
    	$phpExcel = new \PHPExcel();
    	$objSheet = $phpExcel->getActiveSheet();
    	$objSheet->getDefaultStyle()->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(\PHPExcel_Style_Alignment::VERTICAL_CENTER);
    	$objSheet->setTitle('分类列表');
    	$objSheet->setCellValue('A1','序号')->setCellValue('B1','分类名称')->setCellValue('C1','所属板块')->setCellValue('D1','所属类型')
    	->setCellValue('E1','创建时间')->setCellValue('F1','修改时间')->setCellValue('G1','分类描述')->setCellValue('H1','自定义分类');
    	$num  = 2;
    	foreach ($result as $val){
    		$objSheet->setCellValue('A'.$num,$val->id)->setCellValue('B'.$num,$val->text)->setCellValue('C'.$num,$val->parents->codeDesc)->setCellValue('D'.$num,self::$type_arr[$val->type])
    		->setCellValue('E'.$num,MyHelper::timestampToDate($val->createTime))->setCellValue('F'.$num,MyHelper::timestampToDate($val->modifyTime))->setCellValue('G'.$num,$val->descr)->setCellValue('H'.$num,$val->isBase == 1? '否':'是');
    		$num ++;
    	}
    	$objWriter = \PHPExcel_IOFactory::createWriter($phpExcel,'Excel2007');
    	ExcelMolde::exportBrowser('分类列表.xlsx');
    	$objWriter->save('php://output');
    	var_dump($result[0]->parents);
    }
    
    public function getParentCate()
    {
        return  Common::getCommonListByType('navigation');
        //return self::find()->select(['id','text'])->where('parentId = :parentId and isDelete = 0',[':parentId'=>$parentId])->asArray()->all();
    }
    
    public static function getArticleCates(string $type='article')
    {
    	return self::find()->select(['id','text'])->where(['isDelete'=>0,'type'=>$type])->asArray()->all();
    }
    
    public static function del(Category $cate)
    {
        $cate->isDelete = 1;
        return $cate->save(false);
    }
    
}