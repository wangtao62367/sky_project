<?php
namespace common\models;



use common\publics\MyHelper;
use yii\db\ActiveQuery;

/**
 * 课程
 * @author wangtao
 *
 */

class Curriculum extends BaseModel
{
    
    const CURRICULUM_DELETE = 1;
    
    const CURRICULUM_UNDELETE = 0;
    
    public static function tableName()
    {
        return '{{%Curriculum}}';
    }
    
    
    public function rules()
    {
        return [
            ['text','required','message'=>'课程名称不能为空','on'=>['create','edit']],
            ['text', 'string' ,'length'=>[2,20],'tooLong'=>'课程名称长度为4-40个字符', 'tooShort'=>'课程名称长度为2-20个字','on'=>['create','edite']],
            ['period','required','message'=>'课时数不能为空','on'=>['create','edit']],
            ['period','number','message'=>'课时数必须是整数数字','on'=>['create','edit']],
            [['isRequired','remarks','curPage','pageSize','search'],'safe']
        ];
    }
    
    public function create(array $data)
    {
        $this->scenario = 'create';
        if($this->load($data) && $this->validate() && $this->save(false)){
            return true ;
        }
        return false;
    }
    
    public static function edit(array $data,Curriculum $curriculumInfo)
    {
        $curriculumInfo->scenario = 'edit';
        if($curriculumInfo->load($data) && $curriculumInfo->validate() && $curriculumInfo->save(false)){
            return true;
        }
        return  false;
    }
    
    public static function del(int $id,Curriculum $curriculumInfo)
    {
        $curriculumInfo->isDelete = self::CURRICULUM_DELETE;
        return $curriculumInfo->save(false);
    }
    
    public function pageList(array $data)
    {
        $this->curPage = isset($data['curPage']) && !empty($data['curPage']) ? $data['curPage'] : $this->curPage;
        $curriculumListQuery = self::find()->select([])->where(['isDelete'=>self::CURRICULUM_UNDELETE])->orderBy('createTime desc,modifyTime desc');
        if($this->load($data) && !empty($this->search)){
            
        	$curriculumListQuery = $this->filterSearch($this->search, $curriculumListQuery);
            
        }
        $result = $this->query($curriculumListQuery, $this->curPage, $this->pageSize);
        return $result;
    }
    
    public function filterSearch($search,ActiveQuery $query)
    {
    	if(isset($search['text']) && !empty($search['text'])){
    		$query= $query->andWhere(['like','text',$search['text']]);
    	}
    	
    	if(isset($search['isRequired']) && is_numeric($search['isRequired'])){
    		$query= $query->andWhere('isRequired = :isRequired',[':isRequired'=>$search['isRequired']]);
    	}
    	
    	return $query;
    }
    
    public function export(array $data)
    {
        $query = self::find()->select([])->where(['isDelete'=>self::CURRICULUM_UNDELETE])->orderBy('createTime desc,modifyTime desc');
        if($this->load($data) && !empty($this->search)){
        	
        	$query= $this->filterSearch($this->search, $query);
        	
        }
        $result = $query->asArray()->all();
        /* if(empty($result)){
        	return false;
        } */
        
        $phpExcel = new \PHPExcel();
        $objSheet = $phpExcel->getActiveSheet();
        $objSheet->getDefaultStyle()->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(\PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objSheet->setTitle('课程列表');
        $objSheet->setCellValue('A1','序号')->setCellValue('B1','课程名称')->setCellValue('C1','课时数')->setCellValue('D1','是否必修')
        ->setCellValue('E1','主要内容')
        ->setCellValue('F1','创建时间')->setCellValue('G1','修改时间');
        
        //设置填充的样式和背景色
        $colTitle = $objSheet->getStyle('A1:G1');
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
        $objSheet->getColumnDimension('A')->setWidth(10);
        $objSheet->getColumnDimension('B')->setWidth(50);
        $objSheet->getColumnDimension('C')->setWidth(20);
        $objSheet->getColumnDimension('D')->setWidth(20);
        $objSheet->getColumnDimension('E')->setWidth(80);
        $objSheet->getColumnDimension('F')->setWidth(25);
        $objSheet->getColumnDimension('G')->setWidth(25);
        
        $num  = 2;
        foreach ($result as $val){
            $objSheet->setCellValue('A'.$num,$val['id'])->setCellValue('B'.$num,$val['text'])->setCellValue('C'.$num,$val['period'])->setCellValue('D'.$num,$val['isRequired'] == 1 ? '必修':'选修')
            ->setCellValue('E'.$num,$val['remarks'])
            ->setCellValue('F'.$num,MyHelper::timestampToDate($val['createTime']))->setCellValue('G'.$num,MyHelper::timestampToDate($val['modifyTime']));
            $num ++;
        }
        $objWriter = \PHPExcel_IOFactory::createWriter($phpExcel,'Excel2007');
        ExcelMolde::exportBrowser('课程列表.xlsx');
        $objWriter->save('php://output');
    }
}