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
    //判断题
    const QUEST_TRUEORFALSE = 'trueOrfalse';
    /**
     * 未知题型
     * @var string
     */
    const QUEST_UNKNOW = 'unknow';
    
    private static $questCateText = [
        self::QUEST_UNKNOW => '请选择',
        self::QUEST_RADIO => '单选',
        self::QUEST_MULTI => '多选',
        self::QUEST_TRUEORFALSE => '判断'
    ];
    
    /**
     * 获取题型描述
     * @param string $code
     * @return string[]|string
     */
    public static function getQuestCateText(string $code = '')
    {
        return $code ? self::$questCateText[$code] : [
            self::QUEST_UNKNOW => '请选择',
            self::QUEST_RADIO => '单选题',
            self::QUEST_MULTI => '多选题',
            self::QUEST_TRUEORFALSE => '判断题'
        ];
    }
    
}