<?php
namespace common\models;


use Yii;

class QuestOptions extends BaseModel
{
    
    public static function tableName()
    {
        return '{{%QuestOptions}}';
    }
    
    public function rules()
    {
        return [
            
        ];
    }
    /**
     * 批量添加试题选项
     * @param array $data 选项 如：
     *      [
     *          ['opt'=>'这是第一个选项','optImg'=>'第一个图片选项'],
     *          ['opt'=>'这是第二个选项','optImg'=>'第二个图片选项'],
     *          ['opt'=>'这是第三个选项','optImg'=>'第三个图片选项'],
     *      ]
     * @param int $questId 试题ID
     * @return boolean
     */
    public static function batchAdd(array $data,int $questId)
    {
        if(empty($data)) return  false;
        self::deleteAll('questId = :questId',[':questId'=>$questId]);
        $params = [];
        foreach ($data as $k=>$v){
            $params [] = [
                'questId' => $questId,
                'opt'     => $v['opt'],
                'optImg'  => isset($v['optImg']) ? $v['optImg'] : '',
                'sorts'   => $k
            ];
        }
        return (bool)Yii::$app->db->createCommand()->batchInsert(self::tableName(), ['questId','opt','optImg','sorts'], $params)->execute();
    }
}