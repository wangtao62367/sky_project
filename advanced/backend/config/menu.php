<?php
return [
    ['label'=>'控制台','url'=>'default/index','module' => 'default', 'icon' => 'icon-home', 'submenu' => []],
    ['label'=>'管理员系统','url'=>'#','module'=>'','icon'=>'icon-set','submenu'=>[
        ['label'=>'管理员管理','url'=>'admin/index','module'=>'admin'],
        ['label'=>'基础配置','url'=>'base/conf','module'=>'base'],
    ]],
    ['label'=>'网站管理系统','url'=>'#','module'=>'','icon'=>'icon-set','submenu'=>[
        ['label'=>'用户管理','url'=>'user/users','module'=>'user'],
        ['label'=>'投票管理','url'=>'vote/votes','module'=>'vote'],
        ['label'=>'文章管理','url'=>'article/articles','module'=>'article'],
        ['label'=>'图讯管理','url'=>'photo/photos','module'=>'photo'],
        ['label'=>'视讯管理','url'=>'vedio/vedios','module'=>'video'],
        ['label'=>'首页配置','url'=>'home/conf','module'=>'home'],
    ]],
    ['label'=>'社院管理','url'=>'#','module'=>'','icon'=>'icon-set','submenu'=>[
        ['label'=>'学生管理','url'=>'student/students','module'=>'student'],
        ['label'=>'教师管理','url'=>'teacher/teachers','module'=>'teacher'],
        ['label'=>'员工管理','url'=>'staff/rates','module'=>'staff'],
        ['label'=>'课程管理','url'=>'curriculum/curriculums','module'=>'curriculum'],
        ['label'=>'课表管理','url'=>'schedule/schedules','module'=>'schedule'],
        ['label'=>'班级管理','url'=>'gradeclass/gradeclasses','module'=>'gradeclass'],
        ['label'=>'教学点管理','url'=>'teachplace/teachplaces','module'=>'teachplace'],
    ]],
];