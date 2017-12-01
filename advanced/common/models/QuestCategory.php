<?php
namespace common\models;



class QuestCategory
{
    /**
     * 单选题
     * @var string
     */
    const QUEST_RADIO = 'radio';
    /**
     * 多选题
     * @var string
     */
    const QUEST_MULTI = 'multi';
    /**
     * 未知题型
     * @var string
     */
    const QUEST_UNKNOW = 'unknow';
    
    public static function getAnswer()
    {
        
    }
}