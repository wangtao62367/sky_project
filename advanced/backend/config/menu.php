<?php
return [
    ['label'=>'控制台','url'=>'default/index','module' => 'default', 'icon' => 'icon-home', 'submenu' => []],
    ['label'=>'管理员系统','url'=>'#','module'=>'','icon'=>'icon-set','submenu'=>[
        ['label'=>'管理员管理','url'=>'admin/index','module'=>'admin'],
        ['label'=>'基础配置','url'=>'base/conf','module'=>'base'],
        ['label'=>'首页配置','url'=>'home/conf','module'=>'home'],
        ['label'=>'友情链接','url'=>'friend/friends','module'=>'friend'],
        ['label'=>'广告位','url'=>'adver/advers','module'=>'adver'],
    ]],
    ['label'=>'用户系统','url'=>'#','module'=>'','icon'=>'icon-set','submenu'=>[
        ['label'=>'用户管理','url'=>'user/users','module'=>'user'],
        ['label'=>'学员管理','url'=>'student/students','module'=>'student'],
        ['label'=>'学员统计','url'=>'student/students','module'=>'student'],
    ]],
    ['label'=>'新闻系统','url'=>'#','module'=>'','icon'=>'icon-set','submenu'=>[
        ['label'=>'投票管理','url'=>'vote/votes','module'=>'vote'],
        ['label'=>'试题管理','url'=>'question/index','module'=>'question'],
        ['label'=>'新闻管理','url'=>'article/articles','module'=>'article'],
    ]],
    ['label'=>'教务系统','url'=>'#','module'=>'','icon'=>'icon-set','submenu'=>[
        ['label'=>'课表管理','url'=>'schedule/schedules','module'=>'schedule'],
        ['label'=>'教师管理','url'=>'teacher/teachers','module'=>'teacher'],
        ['label'=>'课程管理','url'=>'curriculum/curriculums','module'=>'curriculum'],
        ['label'=>'班级管理','url'=>'gradeclass/gradeclasses','module'=>'gradeclass'],
        ['label'=>'教学点管理','url'=>'teachplace/teachplaces','module'=>'teachplace'],
    ]],
];