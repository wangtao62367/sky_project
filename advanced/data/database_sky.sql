/*
Navicat MySQL Data Transfer

Source Server         : 127.0.0.1
Source Server Version : 50719
Source Host           : 127.0.0.1:3306
Source Database       : database_sky

Target Server Type    : MYSQL
Target Server Version : 50719
File Encoding         : 65001

Date: 2017-12-12 17:07:43
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `sky_admin`
-- ----------------------------
DROP TABLE IF EXISTS `sky_admin`;
CREATE TABLE `sky_admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `account` varchar(50) NOT NULL COMMENT '管理员账号',
  `adminPwd` varchar(150) NOT NULL COMMENT '管理员密码',
  `adminEmail` varchar(100) NOT NULL DEFAULT '' COMMENT '邮箱',
  `loginCount` int(11) NOT NULL DEFAULT '0' COMMENT '登陆IP',
  `loginIp` int(11) NOT NULL DEFAULT '0' COMMENT '登陆IP',
  `lastLoginIp` int(11) NOT NULL DEFAULT '0' COMMENT '上次登陆IP',
  `isSuper` tinyint(2) NOT NULL DEFAULT '0' COMMENT '是否是超级管理员',
  `createTime` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `modifyTime` int(11) NOT NULL DEFAULT '0' COMMENT '编辑时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COMMENT='后台管理系统';

-- ----------------------------
-- Records of sky_admin
-- ----------------------------
INSERT INTO `sky_admin` VALUES ('1', 'sysadmin', '$2y$13$1VBhVtXIoovm728ZnEdG/.uyalV2OyJWUJg4f.DYMVPwiIfwiBwVm', '623672780@qq.com', '0', '0', '0', '1', '1512033870', '1512033870');
INSERT INTO `sky_admin` VALUES ('4', 'admin3', '$2y$13$lJ1Q7QLkCZFvCfFzr7o1t.OG2QMJfk.Kk0qMdEqF9phacm4Uk7Uai', '45641631315@qq.com', '0', '0', '0', '0', '1512033870', '1512108517');
INSERT INTO `sky_admin` VALUES ('6', 'admin4', '$2y$13$6uVqBUQyq2CHzrYEXMIxPOxHx.z4xwBuOBwahRmjwTvGDFK//0Dsy', '456123135132@qq.com', '0', '0', '0', '0', '1512108667', '1512108667');

-- ----------------------------
-- Table structure for `sky_article`
-- ----------------------------
DROP TABLE IF EXISTS `sky_article`;
CREATE TABLE `sky_article` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `title` varchar(200) NOT NULL DEFAULT '' COMMENT '文章标题',
  `titleImg` varchar(100) NOT NULL DEFAULT '' COMMENT '图片标题',
  `author` varchar(50) NOT NULL DEFAULT '' COMMENT '作者',
  `summary` varchar(255) NOT NULL DEFAULT '' COMMENT '文章摘要',
  `content` text NOT NULL COMMENT '文章内容',
  `source` varchar(150) NOT NULL DEFAULT '' COMMENT '文章来源',
  `sourceLinke` varchar(150) NOT NULL DEFAULT '' COMMENT '文章来源链接地址',
  `readCount` int(10) NOT NULL DEFAULT '0' COMMENT '预览数',
  `categoryId` int(11) NOT NULL DEFAULT '0' COMMENT '文章分类ID',
  `isPublish` tinyint(2) NOT NULL DEFAULT '0' COMMENT '是否发布（0否1是）',
  `createTime` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `modifyTime` int(11) NOT NULL DEFAULT '0' COMMENT '编辑时间',
  PRIMARY KEY (`id`),
  KEY `ids_categoryId_isPublish` (`categoryId`,`isPublish`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COMMENT='文章表';

-- ----------------------------
-- Records of sky_article
-- ----------------------------
INSERT INTO `sky_article` VALUES ('9', '测试文章四修改文章', '', '王涛', '测试修改文章', '<p style=\"text-align: center;\">修改文章</p>', '', '', '0', '3', '0', '1511920302', '1511942182');
INSERT INTO `sky_article` VALUES ('11', '测试文章6', '', '王涛', '测试文章6', '<p style=\"text-align: center;\">测试文章5测试文章5测试文章5测试文章5测试文章5测试文章565436</p><p style=\"text-align: center;\">测试文章5测试文章565436</p><p style=\"text-align: center;\">测试文章565436</p><p style=\"text-align: center;\">测试文章565436565434</p>', '', '', '0', '5', '1', '1511942335', '1511942408');
INSERT INTO `sky_article` VALUES ('12', '测试文章5', '', '王涛', '测试文章5', '<p>测试文章5测试文章5测试文章5测试文章5测试文章5测试文章5</p><p>测试文章5测试文章5</p><p>测试文章5</p><p>测试文章5</p><p>测试文章5</p>', '', '', '0', '2', '0', '1511942352', '1511942352');
INSERT INTO `sky_article` VALUES ('13', '测试文章7修改', '', '测试', '大叔大婶', '<p style=\"text-align: center;\">测试文章修改</p>', '', '', '0', '4', '0', '1512034114', '1512034136');

-- ----------------------------
-- Table structure for `sky_articletag`
-- ----------------------------
DROP TABLE IF EXISTS `sky_articletag`;
CREATE TABLE `sky_articletag` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `articleId` int(11) NOT NULL DEFAULT '0' COMMENT '文章ID',
  `tagId` int(11) NOT NULL DEFAULT '0' COMMENT '标签Id',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8 COMMENT='文章标签关系表';

-- ----------------------------
-- Records of sky_articletag
-- ----------------------------
INSERT INTO `sky_articletag` VALUES ('9', '9', '10');
INSERT INTO `sky_articletag` VALUES ('10', '9', '11');
INSERT INTO `sky_articletag` VALUES ('11', '9', '12');
INSERT INTO `sky_articletag` VALUES ('12', '9', '14');
INSERT INTO `sky_articletag` VALUES ('13', '12', '15');
INSERT INTO `sky_articletag` VALUES ('14', '11', '16');
INSERT INTO `sky_articletag` VALUES ('15', '11', '17');
INSERT INTO `sky_articletag` VALUES ('17', '13', '10');

-- ----------------------------
-- Table structure for `sky_category`
-- ----------------------------
DROP TABLE IF EXISTS `sky_category`;
CREATE TABLE `sky_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `text` varchar(50) NOT NULL DEFAULT '' COMMENT '分类名称',
  `parentId` int(11) NOT NULL DEFAULT '0' COMMENT '父级ID',
  `createTime` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `modifyTime` int(11) NOT NULL DEFAULT '0' COMMENT '编辑时间',
  `descr` varchar(150) NOT NULL DEFAULT '' COMMENT '分类描述',
  `positions` enum('top','hot','normal') NOT NULL DEFAULT 'normal' COMMENT '首页位置（top顶部、hot热点位置、normal正常位置）',
  `isDelete` tinyint(2) NOT NULL DEFAULT '0' COMMENT '是否删除（0是1否）',
  `creatAdminId` int(11) NOT NULL DEFAULT '0' COMMENT '创建人ID',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COMMENT='文章分类表';

-- ----------------------------
-- Records of sky_category
-- ----------------------------
INSERT INTO `sky_category` VALUES ('2', '教学培训', '0', '1511833850', '0', '本学院的教学培训展示', 'normal', '0', '0');
INSERT INTO `sky_category` VALUES ('3', '科研动态', '0', '1511833873', '0', '本学院的科研动态展示', 'normal', '0', '0');
INSERT INTO `sky_category` VALUES ('4', '党群建设', '0', '1511833896', '1511840566', '本学院的党群建设展示', 'normal', '0', '0');
INSERT INTO `sky_category` VALUES ('5', '文化交流', '0', '1511833916', '0', '本学院的文化交流最新动态信息展示', 'normal', '0', '0');
INSERT INTO `sky_category` VALUES ('6', '智库中心', '0', '1511833940', '0', '本学院的智库中心最新动态信息展示', 'normal', '0', '0');
INSERT INTO `sky_category` VALUES ('7', '地方社院', '0', '1511833951', '0', '地方社院最新动态信息展示', 'normal', '0', '0');
INSERT INTO `sky_category` VALUES ('8', '统战新闻', '0', '1511833973', '0', '统战新闻最新动态信息展示', 'top', '0', '0');
INSERT INTO `sky_category` VALUES ('9', '新闻活动', '0', '1511833993', '1511849290', '新闻活动最新动态信息展示', 'hot', '0', '0');

-- ----------------------------
-- Table structure for `sky_curriculum`
-- ----------------------------
DROP TABLE IF EXISTS `sky_curriculum`;
CREATE TABLE `sky_curriculum` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `text` varchar(20) NOT NULL DEFAULT '' COMMENT '课程名称',
  `period` tinyint(4) NOT NULL DEFAULT '0' COMMENT '课时',
  `isRequired` tinyint(2) NOT NULL DEFAULT '0' COMMENT '是否必修',
  `remarks` varchar(200) NOT NULL DEFAULT '' COMMENT '备注',
  `isDelete` tinyint(2) NOT NULL DEFAULT '0' COMMENT '是否删除（0否1是；默认0）',
  `createTime` int(10) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `modifyTime` int(10) NOT NULL DEFAULT '0' COMMENT '编辑时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='课程表';

-- ----------------------------
-- Records of sky_curriculum
-- ----------------------------

-- ----------------------------
-- Table structure for `sky_gradeclass`
-- ----------------------------
DROP TABLE IF EXISTS `sky_gradeclass`;
CREATE TABLE `sky_gradeclass` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `grades` int(4) NOT NULL DEFAULT '0' COMMENT '年级',
  `classes` int(4) NOT NULL DEFAULT '0' COMMENT '班',
  `classSize` int(4) NOT NULL DEFAULT '0' COMMENT '班人数',
  `createTime` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `modifyTime` int(11) NOT NULL DEFAULT '0' COMMENT '编辑时间',
  `createAdminId` int(11) NOT NULL DEFAULT '0' COMMENT '创建人Id',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='班级表（年级已年来创建：如2017年 即为 2017级）';

-- ----------------------------
-- Records of sky_gradeclass
-- ----------------------------

-- ----------------------------
-- Table structure for `sky_photo`
-- ----------------------------
DROP TABLE IF EXISTS `sky_photo`;
CREATE TABLE `sky_photo` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `photo` varchar(100) NOT NULL DEFAULT '' COMMENT '图片',
  `descr` varchar(150) NOT NULL DEFAULT '' COMMENT '图片描述',
  `createTime` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='图讯社园表';

-- ----------------------------
-- Records of sky_photo
-- ----------------------------

-- ----------------------------
-- Table structure for `sky_question`
-- ----------------------------
DROP TABLE IF EXISTS `sky_question`;
CREATE TABLE `sky_question` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `title` varchar(100) NOT NULL DEFAULT '' COMMENT '标题',
  `titleImg` varchar(100) NOT NULL DEFAULT '' COMMENT '图片标题',
  `cate` enum('radio','multi','unknow') NOT NULL DEFAULT 'unknow' COMMENT '试题类型（radio单选multi多选unknow未知）',
  `answer` int(5) NOT NULL DEFAULT '0' COMMENT '正确答案',
  `answerOpt` varchar(50) NOT NULL COMMENT '正确选项',
  `score` tinyint(4) NOT NULL DEFAULT '0' COMMENT '分数',
  `isPublish` tinyint(2) NOT NULL DEFAULT '0' COMMENT '是否发布',
  `isDelete` tinyint(2) NOT NULL DEFAULT '0' COMMENT '是否删除',
  `createTime` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `modifyTime` int(11) DEFAULT '0' COMMENT '编辑时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8 COMMENT='微课试题表';

-- ----------------------------
-- Records of sky_question
-- ----------------------------
INSERT INTO `sky_question` VALUES ('20', '测试哦的萨芬撒大范甘迪撒给大哥发的割发代首割发代首功夫大使馆的是否高打赏', '', 'multi', '56', '[\"B\",\"D\",\"E\"]', '5', '0', '0', '1512375299', '1512456937');
INSERT INTO `sky_question` VALUES ('21', '这是第二道选择题，注意答案哦', '', 'multi', '12', '[\"A\",\"B\",\"C\"]', '2', '0', '0', '1512437882', '1512438507');

-- ----------------------------
-- Table structure for `sky_questoptions`
-- ----------------------------
DROP TABLE IF EXISTS `sky_questoptions`;
CREATE TABLE `sky_questoptions` (
  `questId` int(11) NOT NULL DEFAULT '0' COMMENT '试题ID',
  `opt` varchar(100) NOT NULL DEFAULT '' COMMENT '选项',
  `optImg` varchar(100) NOT NULL DEFAULT '' COMMENT '图片选项',
  `sorts` tinyint(4) NOT NULL DEFAULT '0' COMMENT '选项排序',
  PRIMARY KEY (`questId`,`sorts`),
  KEY `ids_questId` (`questId`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='试题选项表 （只针对选择题才会存在选项）';

-- ----------------------------
-- Records of sky_questoptions
-- ----------------------------
INSERT INTO `sky_questoptions` VALUES ('20', '官方', '', '0');
INSERT INTO `sky_questoptions` VALUES ('20', '割发代首', '', '1');
INSERT INTO `sky_questoptions` VALUES ('20', '电风扇', '', '2');
INSERT INTO `sky_questoptions` VALUES ('20', '编辑5435', '', '3');
INSERT INTO `sky_questoptions` VALUES ('20', '7863456', '', '4');
INSERT INTO `sky_questoptions` VALUES ('21', '好的', '', '0');
INSERT INTO `sky_questoptions` VALUES ('21', '没问题', '', '1');
INSERT INTO `sky_questoptions` VALUES ('21', '是的', '', '2');
INSERT INTO `sky_questoptions` VALUES ('21', '要的', '', '3');

-- ----------------------------
-- Table structure for `sky_role`
-- ----------------------------
DROP TABLE IF EXISTS `sky_role`;
CREATE TABLE `sky_role` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `roleName` char(20) NOT NULL DEFAULT '' COMMENT '角色名称',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='角色表';

-- ----------------------------
-- Records of sky_role
-- ----------------------------
INSERT INTO `sky_role` VALUES ('1', '学生');
INSERT INTO `sky_role` VALUES ('2', '教师');
INSERT INTO `sky_role` VALUES ('3', '工作人员');

-- ----------------------------
-- Table structure for `sky_schedule`
-- ----------------------------
DROP TABLE IF EXISTS `sky_schedule`;
CREATE TABLE `sky_schedule` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `curriculumId` int(11) NOT NULL DEFAULT '0' COMMENT '课程id',
  `curriculumText` varchar(20) NOT NULL DEFAULT '' COMMENT '课程名称',
  `lessonDate` date NOT NULL COMMENT '上课日期',
  `lessonTime` varchar(20) NOT NULL DEFAULT '' COMMENT '上课时间段',
  `teacherId` int(11) NOT NULL DEFAULT '0' COMMENT '任课教师ID',
  `teacherName` varchar(50) NOT NULL DEFAULT '' COMMENT '教师名称',
  `teachPlaceId` int(11) NOT NULL DEFAULT '0' COMMENT '教学地点ID',
  `gradeClassId` int(11) NOT NULL DEFAULT '0' COMMENT '班级ID',
  `isPublish` tinyint(2) NOT NULL DEFAULT '0' COMMENT '是否发布（0否1是）',
  `publishTitle` varchar(200) NOT NULL DEFAULT '' COMMENT '发布标题',
  `publishEndDate` int(11) NOT NULL DEFAULT '0' COMMENT '发布结束时间（时间已过自动删除）',
  `isDelete` tinyint(2) NOT NULL DEFAULT '0' COMMENT '是否删除（0否1是）',
  `createTime` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `modifyTime` int(11) NOT NULL DEFAULT '0' COMMENT '编辑时间',
  PRIMARY KEY (`id`),
  KEY `ids_curriculumId_teacherId_teachPlaceId_gradeClassId_isPublish` (`curriculumId`,`teacherId`,`teachPlaceId`,`gradeClassId`,`isPublish`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='学院课表表';

-- ----------------------------
-- Records of sky_schedule
-- ----------------------------

-- ----------------------------
-- Table structure for `sky_student`
-- ----------------------------
DROP TABLE IF EXISTS `sky_student`;
CREATE TABLE `sky_student` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `userId` int(11) NOT NULL COMMENT '用户ID',
  `trueName` varchar(50) DEFAULT '' COMMENT '真实姓名',
  `sex` tinyint(2) NOT NULL DEFAULT '0' COMMENT '性别（0未知1男2女；默认为0）',
  `IDnumber` char(18) NOT NULL DEFAULT '' COMMENT '身份证号',
  `birthday` date NOT NULL COMMENT '出生年月',
  `nation` char(20) NOT NULL DEFAULT '' COMMENT '名族',
  `address` varchar(150) NOT NULL DEFAULT '' COMMENT '联系地址',
  `phone` char(11) NOT NULL DEFAULT '' COMMENT '联系电话',
  `company` varchar(100) NOT NULL DEFAULT '' COMMENT '工作单位（公司）',
  `workYear` tinyint(3) NOT NULL DEFAULT '0' COMMENT '工作年限',
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='学生表';

-- ----------------------------
-- Records of sky_student
-- ----------------------------

-- ----------------------------
-- Table structure for `sky_sysconfig`
-- ----------------------------
DROP TABLE IF EXISTS `sky_sysconfig`;
CREATE TABLE `sky_sysconfig` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='网站系统配置表';

-- ----------------------------
-- Records of sky_sysconfig
-- ----------------------------

-- ----------------------------
-- Table structure for `sky_tag`
-- ----------------------------
DROP TABLE IF EXISTS `sky_tag`;
CREATE TABLE `sky_tag` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `tagName` varchar(50) NOT NULL DEFAULT '' COMMENT '标签名',
  `createTime` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8 COMMENT='文章标签表';

-- ----------------------------
-- Records of sky_tag
-- ----------------------------
INSERT INTO `sky_tag` VALUES ('10', '测试', '1511920302');
INSERT INTO `sky_tag` VALUES ('11', '测试文章四', '1511920302');
INSERT INTO `sky_tag` VALUES ('12', '文 章', '1511920302');
INSERT INTO `sky_tag` VALUES ('13', '文章五', '1511920349');
INSERT INTO `sky_tag` VALUES ('14', '修改文章', '1511942182');
INSERT INTO `sky_tag` VALUES ('15', '文章5', '1511942352');
INSERT INTO `sky_tag` VALUES ('16', '哇6', '1511942408');
INSERT INTO `sky_tag` VALUES ('17', '文章', '1511942408');

-- ----------------------------
-- Table structure for `sky_teachplace`
-- ----------------------------
DROP TABLE IF EXISTS `sky_teachplace`;
CREATE TABLE `sky_teachplace` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `text` varchar(100) NOT NULL DEFAULT '' COMMENT '教学地点',
  `address` varchar(200) NOT NULL DEFAULT '' COMMENT '具体地址',
  `createTime` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `createAdminId` int(11) NOT NULL DEFAULT '0' COMMENT '创建人ID',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='教学地点表';

-- ----------------------------
-- Records of sky_teachplace
-- ----------------------------

-- ----------------------------
-- Table structure for `sky_user`
-- ----------------------------
DROP TABLE IF EXISTS `sky_user`;
CREATE TABLE `sky_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `account` varchar(50) NOT NULL COMMENT '用户名',
  `userPwd` varchar(150) NOT NULL COMMENT '用户密码',
  `phone` char(11) NOT NULL DEFAULT '' COMMENT '手机号',
  `email` varchar(50) NOT NULL DEFAULT '' COMMENT '邮箱',
  `roleId` tinyint(4) NOT NULL COMMENT '角色ID',
  `loginIp` char(10) NOT NULL DEFAULT '' COMMENT '登录IP',
  `lastLoginIp` char(10) NOT NULL DEFAULT '' COMMENT '上次登录Ip',
  `loginCount` int(10) NOT NULL DEFAULT '0' COMMENT '登录次数(默认为0)',
  `isFrozen` tinyint(2) NOT NULL DEFAULT '0' COMMENT '是否冻结（0否1是，默认为0）',
  `isDelete` tinyint(2) NOT NULL DEFAULT '0' COMMENT '是否删除',
  `createTime` int(11) NOT NULL COMMENT '创建时间（时间戳）',
  `modifyTime` int(11) NOT NULL COMMENT '编辑时间（时间戳）',
  PRIMARY KEY (`id`),
  KEY `ids_isDelete` (`isDelete`),
  KEY `ids_roleId` (`roleId`),
  KEY `ids_account_userpwd` (`account`,`userPwd`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='用户表';

-- ----------------------------
-- Records of sky_user
-- ----------------------------
INSERT INTO `sky_user` VALUES ('1', 'wangtao', '$2y$13$6/lbRsLF3N.uKG5I.O0YXOk2sJD.OfpFQzI3qjPtD3juLbTsE/bgm', '', '623672780@qq.com', '1', '', '', '0', '0', '0', '1512444422', '1512453655');

-- ----------------------------
-- Table structure for `sky_video`
-- ----------------------------
DROP TABLE IF EXISTS `sky_video`;
CREATE TABLE `sky_video` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `video` varchar(100) NOT NULL DEFAULT '' COMMENT '视频',
  `descr` varchar(150) NOT NULL DEFAULT '' COMMENT '视频描述',
  `createTime` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='视讯社园表';

-- ----------------------------
-- Records of sky_video
-- ----------------------------

-- ----------------------------
-- Table structure for `sky_vote`
-- ----------------------------
DROP TABLE IF EXISTS `sky_vote`;
CREATE TABLE `sky_vote` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `subject` varchar(200) NOT NULL COMMENT '投票主题',
  `subjectImg` varchar(150) NOT NULL DEFAULT '' COMMENT '投票主题（图片链接地址）',
  `startDate` date NOT NULL COMMENT '投票开始时间',
  `endDate` date NOT NULL COMMENT '结束时间',
  `selectType` enum('single','multi') NOT NULL DEFAULT 'single' COMMENT '选择类型（ single 单选 mulit 多选；默认 single ）',
  `selectCount` tinyint(4) NOT NULL DEFAULT '1' COMMENT '可选数（默认为1；为多选时，不能大于选项总数）',
  `isClose` tinyint(2) NOT NULL DEFAULT '0' COMMENT '是否关闭（0否1是；默认0）',
  `isDelete` tinyint(2) NOT NULL DEFAULT '0' COMMENT '是否删除（0否1是；默认0）',
  `createUserId` int(11) NOT NULL DEFAULT '0' COMMENT '创建人ID（默认0表示系统管理员）',
  `createTime` int(10) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `modifyTime` int(10) NOT NULL DEFAULT '0' COMMENT '编辑时间',
  PRIMARY KEY (`id`),
  KEY `ids_startDate_endDate_isClose_isDelete` (`startDate`,`endDate`,`isClose`,`isDelete`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COMMENT='投票表';

-- ----------------------------
-- Records of sky_vote
-- ----------------------------
INSERT INTO `sky_vote` VALUES ('4', '这是第一个投票', '', '2017-12-05', '2017-12-05', 'multi', '1', '0', '0', '0', '1512438305', '1512438531');
INSERT INTO `sky_vote` VALUES ('5', '这是第二个投票题', '', '2017-12-05', '2017-12-06', 'single', '1', '0', '0', '0', '1512438427', '1512438713');

-- ----------------------------
-- Table structure for `sky_voteoptions`
-- ----------------------------
DROP TABLE IF EXISTS `sky_voteoptions`;
CREATE TABLE `sky_voteoptions` (
  `text` varchar(150) NOT NULL DEFAULT '' COMMENT '选项值',
  `voteId` int(11) NOT NULL DEFAULT '0' COMMENT '投票ID',
  `counts` int(10) NOT NULL DEFAULT '0' COMMENT '投票数',
  `sorts` tinyint(4) NOT NULL COMMENT '排序',
  `createTime` int(10) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `modifyTime` int(10) NOT NULL DEFAULT '0' COMMENT '编辑时间',
  PRIMARY KEY (`voteId`,`sorts`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='投票选项表';

-- ----------------------------
-- Records of sky_voteoptions
-- ----------------------------
INSERT INTO `sky_voteoptions` VALUES ('1', '4', '0', '0', '1512438531', '1512438531');
INSERT INTO `sky_voteoptions` VALUES ('2', '4', '0', '1', '1512438531', '1512438531');
INSERT INTO `sky_voteoptions` VALUES ('第二投票第一选项', '4', '0', '2', '1512438531', '1512438531');
INSERT INTO `sky_voteoptions` VALUES ('第二投票第二选项432', '5', '1', '0', '1512438713', '1512438713');
INSERT INTO `sky_voteoptions` VALUES ('第二投票第三选项打撒', '5', '5', '1', '1512438713', '1512438713');
INSERT INTO `sky_voteoptions` VALUES ('第二投票第四选项好地方撒打算发的', '5', '10', '2', '1512438713', '1512438713');
INSERT INTO `sky_voteoptions` VALUES ('第二投票第五选项', '5', '2', '3', '1512438713', '1512438713');
INSERT INTO `sky_voteoptions` VALUES ('第二投票第六选项范德萨范德萨光伏发电施工方但是光', '5', '15', '4', '1512438713', '1512438713');

-- ----------------------------
-- Table structure for `sky_voteuser`
-- ----------------------------
DROP TABLE IF EXISTS `sky_voteuser`;
CREATE TABLE `sky_voteuser` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `voteId` int(11) NOT NULL DEFAULT '0' COMMENT '投票ID',
  `userId` int(11) NOT NULL DEFAULT '0' COMMENT '用户ID',
  `optionsId` int(11) NOT NULL DEFAULT '0' COMMENT '选项ID',
  `createTime` int(10) NOT NULL DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`),
  KEY `ids_voteId_userId_optionsId` (`userId`,`voteId`,`optionsId`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='投票用户表';

-- ----------------------------
-- Records of sky_voteuser
-- ----------------------------
