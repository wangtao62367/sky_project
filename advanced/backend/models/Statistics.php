<?php
namespace backend\models;



use yii\base\Model;
use common\models\Student;
use yii\db\Expression;

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
        $bySexQuery = Student::find()->select(new Expression('sum(case when sex=1 then 1 else 0 end) male,sum(case when sex=2 then 1 else 0 end) female'))
                ->where('isDelete = 0 and verify =:verify',[':verify'=>Student::STUDENT_VERIFY_STEP2]);
        $bypoliticalStatusQuery = Student::find()->select(['politicalStatus','sum'=>'count(*)'])
                ->where('isDelete = 0 and verify =:verify',[':verify'=>Student::STUDENT_VERIFY_STEP2])
                ->groupBy('politicalStatus');
        $byEduationQuery = Student::find()->select(['eduation','sum'=>'count(*)'])
            ->where('isDelete = 0 and verify =:verify',[':verify'=>Student::STUDENT_VERIFY_STEP2])
            ->groupBy('eduation');
        
        $byCityQuery = Student::find()->select(['city','sum'=>'count(*)'])
        ->where('isDelete = 0 and verify =:verify',[':verify'=>Student::STUDENT_VERIFY_STEP2])
        ->groupBy('city');
        if($this->load($data)){
            $date = $this->year . '-' .$this->month;
            
            $data = date('Y-m',strtotime($date));
            
            
            
        }
        return [
            'bySex' =>   $bySexQuery->asArray()->one(),
            'bypoliticalStatus' =>   $bypoliticalStatusQuery->asArray()->all(),
            'byEduation' =>   $byEduationQuery->asArray()->all(),
            'byCity' =>   $byCityQuery->asArray()->all(),
        ];
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