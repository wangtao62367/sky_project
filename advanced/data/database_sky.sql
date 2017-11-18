######用户表######
DROP TABLE IF EXISTS `sky_User`;
CREATE TABLE `sky_User` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `account` varchar(50) NOT NULL COMMENT '用户名' ,
  `userpwd` varchar(150) NOT NULL COMMENT '用户密码',
  `phone` char(11) NOT NULL DEFAULT '' COMMENT '手机号',
  `email` varchar(50) NOT NULL DEFAULT '' COMMENT '邮箱',
  `roleId` tinyint(4) NOT NULL COMMENT '角色ID',
  `loginIp` char(10) NOT NULL DEFAULT '' COMMENT '登录IP',
  `lastLoginIp` char(10) NOT NULL DEFAULT '' COMMENT '上次登录Ip',
  `loginCount` int(10) NOT NULL DEFAULT 0 COMMENT '登录次数(默认为0)',
  `isFrozen` tinyint(2) NOT NULL DEFAULT 0 COMMENT '是否冻结（0否1是，默认为0）',
  `createTime` int(11) NOT NULL COMMENT '创建时间（时间戳）',
  `modifyTime` int(11) NOT NULL COMMENT '编辑时间（时间戳）',
  PRIMARY KEY (`id`),
  KEY `ids_account_userpwd_phone_email_roleId` (`account`,`userpwd`,`phone`,`email`,`roleId`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='用户表';

######学生表######

DROP TABLE IF EXISTS `sky_Student`;

CREATE TABLE `sky_Student` (
	`id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
	`userId` int(11) NOT NULL COMMENT '用户ID',
	`trueName` varchar(50) DEFAULT '' COMMENT '真实姓名',
	`sex` tinyint(2) NOT NULL DEFAULT 0 COMMENT '性别（0未知1男2女；默认为0）',
	`IDnumber` char(18) NOT NULL DEFAULT '' COMMENT '身份证号',
	`birthday` date NOT NULL  COMMENT '出生年月',
	`nation` char(20) NOT NULL DEFAULT '' COMMENT '名族',
	`address` varchar(150) NOT NULL DEFAULT '' COMMENT '联系地址',
	`phone` char(11) NOT NULL DEFAULT '' COMMENT '联系电话',
	`company` varchar(100) NOT NULL DEFAULT '' COMMENT '工作单位（公司）',
	`workYear` tinyint(3) NOT NULL DEFAULT 0 COMMENT '工作年限',
	`graduationSchool` varchar(50) NOT NULL DEFAULT '' COMMENT '毕业学校',
	`graduationMajor` varchar(50) NOT NULL DEFAULT '' COMMENT '毕业专业',
	`positionalTitles` varchar(50) NOT NULL DEFAULT '' COMMENT '职称',
	`eduation` varchar(20) NOT NULL DEFAULT '' COMMENT '学历',
	`politicalStatus` char(10) NOT NULL DEFAULT '' COMMENT '政治面貌',
	`currentMajor` char(50) NOT NULL DEFAULT '' COMMENT '社院所学专业',
	`gradeClass` varchar(20) NOT NULL DEFAULT '' COMMENT '班级',
	`selfIntruduce` varchar(200) NOT NULL DEFAULT '' COMMENT '个人简历',
	`situation` varchar(200) NOT NULL DEFAULT '' COMMENT '在校情况',
	PRIMARY KEY (`id`),
	KEY `ids_userId_gradeClass` (`userId`,`gradeClass`) USING BTREE
) ENGINE =INNODB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='学生表';

######教师表######

DROP TABLE IF EXISTS 	`sky_Teacher`;

CREATE TABLE `sky_Teacher` (
	`id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
	`userId` int(11) NOT NULL COMMENT '用户ID',

	PRIMARY KEY (`id`)
) ENGINE = INNODB AUTO_INCREMENT = 1 DEFAULT CHARSET=utf8 COMMENT = '教师表';

######工作人员表######

DROP TABLE IF EXISTS `sky_Staff`;

CREATE TABLE `sky_Staff` (
	`id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
	`userId` int(11) NOT NULL COMMENT '用户ID',
 
	PRIMARY KEY (`id`)
) ENGINE = INNODB AUTO_INCREMENT = 1 DEFAULT CHARSET = utf8 COMMENT ='工作人员表';

#####角色表######

DROP TABLE IF EXISTS `sky_Role`;

CREATE TABLE `sky_Role` (
	`id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
	`roleName` char(20) NOT NULL DEFAULT '' COMMENT '角色名称',
		
	PRIMARY KEY (`id`)
) ENGINE = INNODB AUTO_INCREMENT = 1 DEFAULT CHARSET = utf8 COMMENT = '角色表';

#####投票表######

DROP TABLE IF EXISTS `sky_Vote`;

CREATE TABLE `sky_Vote` (
	`id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
	`subject` varchar(200) NOT NULL COMMENT '投票主题',
	`subjectImg` varchar(150) NOT NULL DEFAULT '' COMMENT '投票主题（图片链接地址）',
	`startDate` date NOT NULL COMMENT '投票开始时间',
	`endDate` date NOT NULL COMMENT '结束时间',
	`selectType` enum('single','multi') NOT NULL DEFAULT 'single' COMMENT '选择类型（ single 单选 mulit 多选；默认 single ）',
	`selectCount` tinyint(4) NOT NULL DEFAULT 1 COMMENT '可选数（默认为1；为多选时，不能大于选项总数）',
	`isClose` tinyint(2) NOT NULL DEFAULT 0 COMMENT '是否关闭（0否1是；默认0）',
	`isDelete` tinyint(2) NOT NULL DEFAULT 0 COMMENT '是否删除（0否1是；默认0）',
	`createUserId` int(11) NOT NULL DEFAULT 0 COMMENT '创建人ID（默认0表示系统管理员）',
	`createTime` int(10) NOT NULL DEFAULT 0 COMMENT '创建时间',
	`modifyTime` int(10) NOT NULL DEFAULT 0 COMMENT '编辑时间',

	PRIMARY KEY (`id`),
  KEY `ids_startDate_endDate_isClose_isDelete` (`startDate`,`endDate`,`isClose`,`isDelete`) USING BTREE
) ENGINE = INNODB AUTO_INCREMENT = 1 DEFAULT CHARSET = utf8 COMMENT = '投票表';

#####投票选项表#######

DROP TABLE IF EXISTS `sky_VoteOptions`;

CREATE TABLE `sky_VoteOptions` (
	`id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
	`text` varchar(150) NOT NULL DEFAULT '' COMMENT '选项值',
	`voteId` int(11) NOT NULL DEFAULT 0 COMMENT '投票ID',
	`counts` int(10) NOT NULL DEFAULT 0 COMMENT '投票数',
	`createTime` int(10) NOT NULL DEFAULT 0 COMMENT '创建时间',
	`modifyTime` int(10) NOT NULL DEFAULT 0 COMMENT '编辑时间',			
	PRIMARY KEY (`id`)
) ENGINE = INNODB AUTO_INCREMENT = 1 DEFAULT CHARSET = utf8 COMMENT = '投票选项表';

#####投票用户表######

DROP TABLE IF EXISTS `sky_VoteUser`;

CREATE TABLE `sky_VoteUser` (
	`id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
	`voteId` int(11) NOT NULL DEFAULT 0 COMMENT '投票ID',
	`userId` 	int(11) NOT NULL DEFAULT 0 COMMENT '用户ID',
	`optionsId` int(11) NOT NULL DEFAULT 0 COMMENT '选项ID',
	`createTime` int(10) NOT NULL DEFAULT 0 COMMENT '创建时间',
	PRIMARY KEY (`id`),
	KEY `ids_voteId_userId_optionsId` (`userId`,`voteId`,`optionsId`) USING BTREE
)  ENGINE = INNODB AUTO_INCREMENT = 1 DEFAULT CHARSET = utf8 COMMENT = '投票用户表';

#####课程表######

DROP TABLE IF EXISTS `sky_Curriculum`;

CREATE TABLE `sky_Curriculum` (
	`id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
	`text` varchar(20) NOT NULL DEFAULT '' COMMENT '课程名称',
	`period` tinyint(4) NOT NULL DEFAULT 0 COMMENT '课时',
	`isRequired` tinyint(2) NOT NULL DEFAULT 0 COMMENT '是否必修',
	`remarks` varchar(200) NOT NULL DEFAULT '' COMMENT '备注',
	`isDelete` tinyint(2) NOT NULL DEFAULT 0 COMMENT '是否删除（0否1是；默认0）',
	`createTime` int(10) NOT NULL DEFAULT 0 COMMENT '创建时间',
	`modifyTime` int(10) NOT NULL DEFAULT 0 COMMENT '编辑时间',			

	PRIMARY KEY (`id`)
) ENGINE = INNODB AUTO_INCREMENT =1 DEFAULT CHARSET =utf8 COMMENT ='课程表';

