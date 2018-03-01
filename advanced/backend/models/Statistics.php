<?php
namespace backend\models;


use Yii;
use yii\base\Model;
use common\models\Student;
use yii\db\Expression;
use common\models\BmRecord;

/**
 * 统计管理
 * @author wt
 *
 */
class Statistics extends Model
{
    public $year;
    
    public $month;
    
    public $yearArr ;
    
    public $monthArr ;
    
    public function rules()
    {
        return [
            [['year','month'],'safe']
        ];
    }
    
    public function students(array $data)
    {
        $bySexQuery = BmRecord::find()->joinWith(['student'])
        ->select([new Expression('case when sex =2 then "女" else "男" end as sex'),'sum'=>'count(*)'])
        ->where([
            BmRecord::tableName().'.verify'=>BmRecord::STUDENT_VERIFY_FINISH,
            Student::tableName().'.isDelete' => 0,
        ])->groupBy('sex,gradeClassId');
        
        
        
        $bypoliticalStatusQuery = BmRecord::find()->joinWith('student')
        ->select(['politicalStatus','sum'=>'count(*)'])
        ->where([
            BmRecord::tableName().'.verify'=>BmRecord::STUDENT_VERIFY_FINISH,
            Student::tableName().'.isDelete' => 0,
        ])->groupBy('politicalStatus,gradeClassId');
        
        $byEduationQuery = BmRecord::find()->joinWith('student')
        ->select(['eduation','sum'=>'count(*)'])
        ->where([
            BmRecord::tableName().'.verify'=>BmRecord::STUDENT_VERIFY_FINISH,
            Student::tableName().'.isDelete' => 0,
        ])->groupBy('eduation,gradeClassId');
        
        $byCityQuery = BmRecord::find()->joinWith('student')
        ->select(['city','sum'=>'count(*)'])
        ->where([
            BmRecord::tableName().'.verify'=>BmRecord::STUDENT_VERIFY_FINISH,
            Student::tableName().'.isDelete' => 0,
        ])->groupBy('city,gradeClassId');
        
        
        if($this->load($data)){
            $date = $this->year . '-' .$this->month;
            $data = date('Y-m',strtotime($date));
            $bySexQuery = $bySexQuery->andWhere('FROM_UNIXTIME('.BmRecord::tableName().'.modifyTime,\'%Y-%m\') = :date',[':date'=>$data]);
            $bypoliticalStatusQuery= $bypoliticalStatusQuery->andWhere('FROM_UNIXTIME('.BmRecord::tableName().'.modifyTime,\'%Y-%m\') = :date',[':date'=>$data]);
            $byEduationQuery= $byEduationQuery->andWhere('FROM_UNIXTIME('.BmRecord::tableName().'.modifyTime,\'%Y-%m\') = :date',[':date'=>$data]);
            $byCityQuery= $byCityQuery->andWhere('FROM_UNIXTIME('.BmRecord::tableName().'.modifyTime,\'%Y-%m\') = :date',[':date'=>$data]);
        }

        return [
            'bySex' =>   $bySexQuery->createCommand()->queryAll(),
            'bypoliticalStatus' =>   $bypoliticalStatusQuery->createCommand()->queryAll(),
            'byEduation' =>   $byEduationQuery->createCommand()->queryAll(),
            'byCity' =>   $byCityQuery->createCommand()->queryAll(),
        ];
    }
    /**
     * 导出学员统计信息
     * @param unknown $result
     */
    public function exportStudent($result)
    {
        $phpExcel = new \PHPExcel();
        $objSheet = $phpExcel->getActiveSheet();
        
    }
    
    
    public static function makeYearAndMonth()
    {
        $nowYear = date('Y');
        $startYear = $nowYear-10;
        $result = [];
        for ($i=$startYear;$i<= $nowYear;$i++){
            $result['years'][] = [
                'id'=>$i,
                'text' => $i
            ];
        }
        
        for ($i=1;$i<= 12;$i++){
            $result['months'][] = [
                'id'=>$i,
                'text' => $i
            ];
        }
        return $result;
    }
    
}