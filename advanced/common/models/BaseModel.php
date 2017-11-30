<?php
namespace common\models;


use yii\db\ActiveRecord;
use yii\db\ActiveQuery;
use yii\behaviors\TimestampBehavior;

class BaseModel extends ActiveRecord
{
    public $curPage = 1;
    
    public $pageSize= 15;
    
    public $search ;
    
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'createTime',
                'updatedAtAttribute' => 'modifyTime',
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['createTime','modifyTime'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['modifyTime']
                ]
            ]
        ];
    }
    
    
    public function query(ActiveQuery $query,int $curPage = 1,int $pageSize = 10 ,$search = null)
    {
        if(!empty($search)){
            $query = $query->filterWhere($search);
        }
        $data['count'] = (int)$query->count();
        if(!$data['count']){
            return ['count'=>0,'curPage'=>$curPage,'pageSize'=>$pageSize,'start'=>0,
                'end'=>0,'data'=>[]
            ];
        }
        //当前页
        $data['curPage']  = (int)$curPage;
        //每页显示条数
        $data['pageSize'] = (int)$pageSize;
        //起始页
        $data['start']    =($curPage - 1)*$pageSize + 1;
        //末页
        $data['end']      = (ceil($data['count']/$pageSize) == $curPage)
                                ?$data['count']:($curPage-1)*$pageSize+$pageSize;
        //数据
        $data['data']     = $query -> offset(($curPage-1)*$pageSize)
                            ->limit($pageSize)
                            ->asArray()
                            ->all();
        return $data;
    }
    
}