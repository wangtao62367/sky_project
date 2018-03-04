<?php
namespace common\models;


use common\publics\MyHelper;
use yii\db\ActiveQuery;

/**
 * 教学点
 * @author wangtao
 *
 */

class TeachPlace extends BaseModel
{
    const TEACHPLACE_DELETE = 1;
    const TEACHPLACE_UNDELETE = 0;
    
    public static function tableName()
    {
        return '{{%TeachPlace}}';
    }
    
    public function rules()
    {
        return [
            ['text','required','message'=>'教学地点不能为空','on'=>['create','edit']],
            ['text', 'string', 'length' => [2, 20], 'tooLong'=>'教学地点长度为4-40个字符', 'tooShort'=>'教学地点长度为2-20个字','on'=>['create','edite']],
        	['contacts','required','message'=>'教学地点联络人不能为空','on'=>['create','edit']],
        	['phone','required','message'=>'联络人手机号不能为空','on'=>['create','edit']],
        	['phone','match','pattern'=>'/^[1][34578][0-9]{9}$/','message'=>'联络人手机号无效','on'=>['create','edit']],
        	[['address','createAdminId','curPage','pageSize','search','website','equipRemarks','remarks'],'safe'],
        ];
    }
    
    public function create(array $data)
    {
        $this->scenario = 'create';
        if($this->load($data) && $this->validate() && $this->save(false)){
            return true;
        }
        return false;
    }
    
    public static function edit(array $data , TeachPlace $teachPlaceInfo)
    {
        $teachPlaceInfo->scenario = 'edit';
        if($teachPlaceInfo->load($data) && $teachPlaceInfo->validate() && $teachPlaceInfo->save(false)){
            return true;
        }
        return false;
    }
    
    public static function del(int $id,TeachPlace $teachPlaceInfo)
    {
        $teachPlaceInfo->isDelete = self::TEACHPLACE_DELETE;
        return $teachPlaceInfo->save(false);
    }
    
    
    public function pageList(array $data)
    {
        $this->curPage = isset($data['curPage']) && !empty($data['curPage']) ? $data['curPage'] : $this->curPage;
        $query = self::find()->select(['id','text','address','website','contacts','phone','equipRemarks','createTime','modifyTime'])->where(['isDelete'=>self::TEACHPLACE_UNDELETE])->orderBy('createTime desc,modifyTime desc');
        if($this->load($data) && !empty($this->search) ){
        	$query = $this->filterSearch($this->search,$query);
        }
        $list = $this->query($query, $this->curPage, $this->pageSize);
        return $list;
    }
    
    public function filterSearch($search,ActiveQuery $query)
    {
    	if(isset($search['keywords']) && !empty($search['keywords'])){
    		$query= $query->andWhere([
    				'or',
    				['like','text',$this->search['keywords']],
    				['like','address',$this->search['keywords']],
    		]);
    	}
    	
    	if(isset($search['contacts']) && !empty($search['contacts'])){
    		$query = $query->andWhere(['like','contacts',$search['contacts']]);
    	}
    	
    	if(!empty($search['startTime'])){
    		$query = $query->andWhere('createTime >= :startTime',[':startTime'=>strtotime($search['startTime'])]);
    	}
    	if(!empty($search['endTime'])){
    		$query = $query->andWhere('createTime <= :endTime',[':endTime'=>strtotime($search['endTime'])]);
    	}
    		
    	return $query;
    }
    
    public function export(array $data)
    {
    	$query = self::find()->select(['id','text','address','website','contacts','phone','equipRemarks','createTime','modifyTime'])->where(['isDelete'=>self::TEACHPLACE_UNDELETE])->orderBy('createTime desc,modifyTime desc');
        if($this->load($data) && !empty($this->search) ){
        	$query = $this->filterSearch($this->search,$query);
        }
        $result = $query->asArray()->all();
        if(empty($result)){
        	return false;
        }
        
        $phpExcel = new \PHPExcel();
        $objSheet = $phpExcel->getActiveSheet();
        $objSheet->getDefaultStyle()->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(\PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objSheet->setTitle('教学点列表');
        $objSheet->setCellValue('A1','序号')->setCellValue('B1','教学点')->setCellValue('C1','联络人')->setCellValue('D1','联系手机')
        ->setCellValue('E1','设备情况')->setCellValue('F1','详细地址')->setCellValue('G1','教学网址')
        ->setCellValue('H1','创建时间')->setCellValue('I1','修改时间');
        
        //设置填充的样式和背景色
        $colTitle = $objSheet->getStyle('A1:I1');
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
        $objSheet->getColumnDimension('C')->setWidth(25);
        $objSheet->getColumnDimension('D')->setWidth(30);
        $objSheet->getColumnDimension('E')->setWidth(80);
        $objSheet->getColumnDimension('F')->setWidth(50);
        $objSheet->getColumnDimension('G')->setWidth(50);
        $objSheet->getColumnDimension('H')->setWidth(25);
        $objSheet->getColumnDimension('I')->setWidth(25);
        
        $num  = 2;
        foreach ($result as $val){
            $objSheet->setCellValue('A'.$num,$val['id'])->setCellValue('B'.$num,$val['text'])->setCellValue('C'.$num,$val['contacts'])->setCellValue('D'.$num,$val['phone'])
            ->setCellValue('E'.$num,$val['equipRemarks'])->setCellValue('F'.$num,$val['address'])->setCellValue('G'.$num,$val['website'])
            ->setCellValue('H'.$num,MyHelper::timestampToDate($val['createTime']))->setCellValue('I'.$num,MyHelper::timestampToDate($val['modifyTime']));
            $num ++;
        }
        $objWriter = \PHPExcel_IOFactory::createWriter($phpExcel,'Excel2007');
        ExcelMolde::exportBrowser('教学点列表.xlsx');
        $objWriter->save('php://output');
    }
}