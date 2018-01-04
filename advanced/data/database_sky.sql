/*
Navicat MySQL Data Transfer

Source Server         : 127.0.0.1
Source Server Version : 50719
Source Host           : 127.0.0.1:3306
Source Database       : database_sky

Target Server Type    : MYSQL
Target Server Version : 50719
File Encoding         : 65001

Date: 2018-01-04 17:42:42
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
  `isFrozen` tinyint(2) NOT NULL DEFAULT '0' COMMENT '是否冻结',
  `createTime` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `modifyTime` int(11) NOT NULL DEFAULT '0' COMMENT '编辑时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COMMENT='后台管理系统';

-- ----------------------------
-- Records of sky_admin
-- ----------------------------
INSERT INTO `sky_admin` VALUES ('1', 'sysadmin', '$2y$13$1VBhVtXIoovm728ZnEdG/.uyalV2OyJWUJg4f.DYMVPwiIfwiBwVm', '623672780@qq.com', '6', '2130706433', '2130706433', '1', '0', '1512033870', '1515034890');
INSERT INTO `sky_admin` VALUES ('4', 'admin3', '$2y$13$lJ1Q7QLkCZFvCfFzr7o1t.OG2QMJfk.Kk0qMdEqF9phacm4Uk7Uai', '45641631315@qq.com', '0', '0', '0', '0', '0', '1512033870', '1512108517');
INSERT INTO `sky_admin` VALUES ('6', 'admin4', '$2y$13$6uVqBUQyq2CHzrYEXMIxPOxHx.z4xwBuOBwahRmjwTvGDFK//0Dsy', '456123135132@qq.com', '0', '0', '0', '0', '0', '1512108667', '1512108667');

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
  `isDelete` tinyint(2) NOT NULL DEFAULT '0' COMMENT '是否删除',
  `createTime` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `modifyTime` int(11) NOT NULL DEFAULT '0' COMMENT '编辑时间',
  `imgCount` tinyint(4) NOT NULL DEFAULT '0' COMMENT '文章包含的图片数',
  PRIMARY KEY (`id`),
  KEY `ids_categoryId_isPublish` (`categoryId`,`isPublish`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COMMENT='文章表';

-- ----------------------------
-- Records of sky_article
-- ----------------------------
INSERT INTO `sky_article` VALUES ('9', '测试文章四修改文章', '', '王涛', '测试修改文章', '<p style=\"text-align: center;\">修改文章</p>', '', '', '0', '3', '0', '1', '1511920302', '1514863310', '0');
INSERT INTO `sky_article` VALUES ('11', '测试文章6', '', '王涛', '测试文章6', '<p style=\"text-align: center;\">测试文章5测试文章5测试文章5测试文章5测试文章5测试文章565436</p><p style=\"text-align: center;\">测试文章5测试文章565436</p><p style=\"text-align: center;\">测试文章565436</p><p style=\"text-align: center;\">测试文章565436565434</p>', '', '', '0', '5', '1', '1', '1511942335', '1511942408', '0');
INSERT INTO `sky_article` VALUES ('12', '测试文章5', '', '王涛', '测试文章5', '<p>测试文章5测试文章5测试文章5测试文章5测试文章5测试文章5</p><p>测试文章5测试文章5</p><p>测试文章5</p><p>测试文章5</p><p>测试文章5</p>', '', '', '0', '2', '0', '1', '1511942352', '1511942352', '0');
INSERT INTO `sky_article` VALUES ('13', '测试文章7修改', '', '测试', '大叔大婶', '<p style=\"text-align: center;\">测试文章修改</p>', '', '', '0', '4', '0', '1', '1512034114', '1512034136', '0');
INSERT INTO `sky_article` VALUES ('14', '测试文章64536453', '', '王涛', '这是一篇测试文章，测试文章64536453测试文章64536453测试文章64536453测试文章64536453测试文章64536453', '<p style=\"text-align: center;\">测试文章64536453测试文章64536453测试文章64536453测试文章64536453测试文章64536453测试文章64536453测试文章64536453测试文章64536453测试文章64536453测试文章64536453</p>', '', '', '0', '2', '1', '1', '1514860825', '1514862801', '0');
INSERT INTO `sky_article` VALUES ('15', '测试文章1', '', '王涛', '这是一篇测试文章', '<p>测试文章1测试文章1测试文章1测试文章1测试文章1测试文章1测试文章1测试文章1测试文章1测试文章1</p><p>章1测试文章1测试文章1测试文章1测试文章1测试文章1</p><p style=\"text-align: center;\"><img src=\"http://seving-weixin.oss-cn-shenzhen.aliyuncs.com/upload/article/20180102/1514876117905641.jpg\" title=\"1514876117905641.jpg\" alt=\"BANNER-s.jpg\"/></p>', '', '', '0', '9', '0', '0', '1514876135', '1514876135', '3');
INSERT INTO `sky_article` VALUES ('16', '这是测试文章法法师范德萨范德萨发公司大幅发送大范甘迪萨法范德萨范德萨发范德萨发的发发范德萨发斯蒂芬富士达范德萨范德萨发', '', '王涛', '这是测试文章法法师范德萨范德萨发公司大幅发送大范甘迪萨法范德萨范德萨发范德萨发的发发范德萨发', '<p>这是测试文章法法师范德萨范德萨发公司大幅发送大范甘迪萨法范德萨范德萨发范德萨发的发发范德萨发这是测试文章法法师范德萨范德萨发公司大幅发送大范甘迪萨法范德萨范德萨发范德萨发的发发范德萨发这是测试文章法法师范德萨范德萨发公司大幅发送大范甘迪萨法范德萨范德萨发范德萨发的发发范德萨发</p>', '', '', '0', '9', '0', '0', '1514965932', '1514965932', '3');

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
-- Table structure for `sky_beststudent`
-- ----------------------------
DROP TABLE IF EXISTS `sky_beststudent`;
CREATE TABLE `sky_beststudent` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `stuName` varchar(50) NOT NULL COMMENT '学员名称',
  `stuPhoto` varchar(100) NOT NULL COMMENT '学员照片',
  `stuIntroduce` text COMMENT '个人介绍',
  `createTime` int(11) NOT NULL COMMENT '创建时间',
  `modifyTime` int(11) NOT NULL COMMENT '编辑时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='优秀学员表（学员风采表）';

-- ----------------------------
-- Records of sky_beststudent
-- ----------------------------

-- ----------------------------
-- Table structure for `sky_bottomlink`
-- ----------------------------
DROP TABLE IF EXISTS `sky_bottomlink`;
CREATE TABLE `sky_bottomlink` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `linkName` varchar(50) NOT NULL COMMENT '链接名称',
  `linkImg` varchar(100) DEFAULT NULL COMMENT '链接图标',
  `linkUrl` varchar(100) NOT NULL COMMENT '链接URL地址',
  `linkCate` varchar(20) NOT NULL COMMENT '链接类型',
  `createTime` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `modifyTime` int(11) NOT NULL DEFAULT '0' COMMENT '编辑时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='友情链接表';

-- ----------------------------
-- Records of sky_bottomlink
-- ----------------------------

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
  `type` enum('video','image','file','article') NOT NULL DEFAULT 'article' COMMENT '分类类型',
  `isDelete` tinyint(2) NOT NULL DEFAULT '0' COMMENT '是否删除（0是1否）',
  `creatAdminId` int(11) NOT NULL DEFAULT '0' COMMENT '创建人ID',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COMMENT='文章分类表';

-- ----------------------------
-- Records of sky_category
-- ----------------------------
INSERT INTO `sky_category` VALUES ('7', '测试分类', '4', '1514872952', '1514875892', '', 'normal', 'article', '1', '0');
INSERT INTO `sky_category` VALUES ('8', '测试分类2', '5', '1514873289', '1514873289', 'Z合适测试分类', 'normal', 'image', '1', '0');
INSERT INTO `sky_category` VALUES ('9', '学院简介', '4', '1514873811', '1514873811', '学院简介描述信息', 'normal', 'article', '0', '0');
INSERT INTO `sky_category` VALUES ('10', '测试分类3', '4', '1514873863', '1514873863', '测试分类3测试分类3测试分类3测试分类3', 'normal', 'article', '0', '0');

-- ----------------------------
-- Table structure for `sky_common`
-- ----------------------------
DROP TABLE IF EXISTS `sky_common`;
CREATE TABLE `sky_common` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `code` varchar(20) NOT NULL COMMENT '配置标识',
  `codeDesc` varchar(50) NOT NULL COMMENT '配置描述',
  `type` varchar(20) NOT NULL COMMENT '配置类型（同一类型值一样）',
  `typeDesc` varchar(50) NOT NULL,
  `sorts` int(10) NOT NULL DEFAULT '0' COMMENT '排序(顺序排,越大越靠后）',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 COMMENT='常用配置表';

-- ----------------------------
-- Records of sky_common
-- ----------------------------
INSERT INTO `sky_common` VALUES ('1', 'friendship', '友情链接', 'bottomLink', '底部链接', '1');
INSERT INTO `sky_common` VALUES ('2', 'sylink', '社院导航', 'bottomLink', '底部链接', '2');
INSERT INTO `sky_common` VALUES ('3', 'dflink', '地方社院', 'bottomLink', '底部链接', '3');
INSERT INTO `sky_common` VALUES ('4', 'school', '学院概况', 'navigation', '首页导航', '1');
INSERT INTO `sky_common` VALUES ('5', 'news', '新闻活动', 'navigation', '首页导航', '2');
INSERT INTO `sky_common` VALUES ('6', 'jxpx', '教学培训', 'navigation', '首页导航', '3');
INSERT INTO `sky_common` VALUES ('7', 'kydt', '科研动态', 'navigation', '首页导航', '4');
INSERT INTO `sky_common` VALUES ('8', 'whxy', '文化学院', 'navigation', '首页导航', '5');
INSERT INTO `sky_common` VALUES ('9', 'xytd', '学员天地', 'navigation', '首页导航', '6');
INSERT INTO `sky_common` VALUES ('10', 'zkzx', '智库中心', 'navigation', '首页导航', '7');
INSERT INTO `sky_common` VALUES ('11', 'xzzx', '下载中心', 'navigation', '首页导航', '9');
INSERT INTO `sky_common` VALUES ('12', 'xxhjs', '信息化建设', 'navigation', '首页导航', '8');
INSERT INTO `sky_common` VALUES ('13', 'currentLeader', '现任领导', 'personage', '社院人物', '0');
INSERT INTO `sky_common` VALUES ('14', 'visitedProfessor', '做客教授', 'personage', '社院人物', '0');

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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='课程表';

-- ----------------------------
-- Records of sky_curriculum
-- ----------------------------
INSERT INTO `sky_curriculum` VALUES ('1', '毛泽东思想与政治', '20', '1', '学习毛泽东主要思想与政治策略', '0', '1514445446', '1514445446');
INSERT INTO `sky_curriculum` VALUES ('2', '测试课程', '16', '0', '', '1', '1514445643', '1514445754');
INSERT INTO `sky_curriculum` VALUES ('3', '测试课程', '32', '0', '', '0', '1514445768', '1514445768');

-- ----------------------------
-- Table structure for `sky_gradeclass`
-- ----------------------------
DROP TABLE IF EXISTS `sky_gradeclass`;
CREATE TABLE `sky_gradeclass` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `className` varchar(50) NOT NULL COMMENT '班级名称',
  `classSize` int(4) NOT NULL DEFAULT '0' COMMENT '班人数',
  `createTime` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `modifyTime` int(11) NOT NULL DEFAULT '0' COMMENT '编辑时间',
  `isDelete` tinyint(2) NOT NULL DEFAULT '0' COMMENT '是否删除',
  `createAdminId` int(11) NOT NULL DEFAULT '0' COMMENT '创建人Id',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='班级表';

-- ----------------------------
-- Records of sky_gradeclass
-- ----------------------------
INSERT INTO `sky_gradeclass` VALUES ('1', '政治思想班', '30', '1514441266', '1514441518', '0', '1');
INSERT INTO `sky_gradeclass` VALUES ('2', '测试班', '20', '1514442000', '1514442056', '1', '1');
INSERT INTO `sky_gradeclass` VALUES ('3', '测试二班', '22', '1514442122', '1514442122', '1', '1');

-- ----------------------------
-- Table structure for `sky_naire`
-- ----------------------------
DROP TABLE IF EXISTS `sky_naire`;
CREATE TABLE `sky_naire` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `title` varchar(100) NOT NULL COMMENT '调查主题',
  `voteCount` tinyint(4) NOT NULL COMMENT '调查卷内投票试题数',
  `isPublish` tinyint(2) NOT NULL DEFAULT '0' COMMENT '是否发布',
  `marks` varchar(255) DEFAULT NULL COMMENT '备注',
  `isDelete` tinyint(2) NOT NULL DEFAULT '0' COMMENT '是否删除',
  `createTime` int(11) NOT NULL COMMENT '创建时间',
  `modifyTime` int(11) NOT NULL COMMENT '修改时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COMMENT='问卷调查表';

-- ----------------------------
-- Records of sky_naire
-- ----------------------------
INSERT INTO `sky_naire` VALUES ('11', '测试问卷调查试卷', '1', '0', '范德萨范德萨发', '0', '1515056724', '1515056724');

-- ----------------------------
-- Table structure for `sky_nairevote`
-- ----------------------------
DROP TABLE IF EXISTS `sky_nairevote`;
CREATE TABLE `sky_nairevote` (
  `naireId` int(11) NOT NULL COMMENT '调查试卷ID',
  `voteId` int(11) NOT NULL COMMENT '调查试题表',
  `sorts` tinyint(4) NOT NULL DEFAULT '1' COMMENT '排序'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='调查试卷与调查题关系表';

-- ----------------------------
-- Records of sky_nairevote
-- ----------------------------
INSERT INTO `sky_nairevote` VALUES ('11', '7', '1');

-- ----------------------------
-- Table structure for `sky_navrelation`
-- ----------------------------
DROP TABLE IF EXISTS `sky_navrelation`;
CREATE TABLE `sky_navrelation` (
  `navId` int(11) NOT NULL COMMENT '导航Id',
  `cateId` int(11) NOT NULL COMMENT '分类Id'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sky_navrelation
-- ----------------------------

-- ----------------------------
-- Table structure for `sky_personage`
-- ----------------------------
DROP TABLE IF EXISTS `sky_personage`;
CREATE TABLE `sky_personage` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `fullName` varchar(50) NOT NULL COMMENT '姓名',
  `photo` varchar(100) NOT NULL,
  `duties` varchar(150) NOT NULL COMMENT '职务描述',
  `intruduce` text NOT NULL COMMENT '个人简介',
  `role` varchar(20) NOT NULL COMMENT '人物角色',
  `createTime` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `modifyTime` int(11) NOT NULL DEFAULT '0' COMMENT '编辑时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='社科院人物表';

-- ----------------------------
-- Records of sky_personage
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
  `isDelete` tinyint(2) NOT NULL DEFAULT '0' COMMENT '是否删除',
  `createTime` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `modifyTime` int(11) DEFAULT '0' COMMENT '编辑时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8 COMMENT='微课试题表';

-- ----------------------------
-- Records of sky_question
-- ----------------------------
INSERT INTO `sky_question` VALUES ('28', '第一试题', '', 'radio', '4', '[\"B\"]', '0', '1515036959', '1515036959');
INSERT INTO `sky_question` VALUES ('29', '第二卷第一道试题', '', 'radio', '4', '[\"B\"]', '0', '1515037173', '1515037173');
INSERT INTO `sky_question` VALUES ('30', '新家试题二', '', 'multi', '4', '[\"B\"]', '0', '1515039207', '1515039207');
INSERT INTO `sky_question` VALUES ('31', '第二试题', '', 'multi', '12', '[\"B\",\"C\"]', '0', '1515045067', '1515045067');

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
INSERT INTO `sky_questoptions` VALUES ('28', '大萨达撒撒多', '', '0');
INSERT INTO `sky_questoptions` VALUES ('28', '大的撒范德萨发', '', '1');
INSERT INTO `sky_questoptions` VALUES ('29', '654654636', '', '0');
INSERT INTO `sky_questoptions` VALUES ('29', '53654364536', '', '1');
INSERT INTO `sky_questoptions` VALUES ('30', '876567856', '', '0');
INSERT INTO `sky_questoptions` VALUES ('30', '78765867586', '', '1');
INSERT INTO `sky_questoptions` VALUES ('31', '的撒范德萨', '', '0');
INSERT INTO `sky_questoptions` VALUES ('31', '范德萨发', '', '1');
INSERT INTO `sky_questoptions` VALUES ('31', '大范德萨发', '', '2');

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
-- Table structure for `sky_teacher`
-- ----------------------------
DROP TABLE IF EXISTS `sky_teacher`;
CREATE TABLE `sky_teacher` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `trueName` varchar(50) NOT NULL COMMENT '教师名称',
  `sex` tinyint(2) NOT NULL DEFAULT '1' COMMENT '教师性别（1男2女）',
  `positionalTitles` varchar(100) NOT NULL COMMENT '职称',
  `isDelete` tinyint(2) DEFAULT '0' COMMENT '是否删除（0否1是）',
  `createTime` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `modifyTime` int(11) NOT NULL DEFAULT '0' COMMENT '编辑时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='教师表';

-- ----------------------------
-- Records of sky_teacher
-- ----------------------------
INSERT INTO `sky_teacher` VALUES ('1', '王老师', '1', '高级教师、教学主任', '1', '1514443430', '1514443854');
INSERT INTO `sky_teacher` VALUES ('2', '李四', '2', '特技教师', '1', '1514443789', '1514443789');
INSERT INTO `sky_teacher` VALUES ('3', '王五', '1', '高级教师、教学编导', '0', '1514443813', '1514443813');

-- ----------------------------
-- Table structure for `sky_teachplace`
-- ----------------------------
DROP TABLE IF EXISTS `sky_teachplace`;
CREATE TABLE `sky_teachplace` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `text` varchar(100) NOT NULL DEFAULT '' COMMENT '教学地点',
  `address` varchar(200) NOT NULL DEFAULT '' COMMENT '具体地址',
  `createTime` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `modifyTime` int(11) NOT NULL DEFAULT '0' COMMENT '编辑时间',
  `isDelete` tinyint(2) NOT NULL DEFAULT '0' COMMENT '是否删除',
  `createAdminId` int(11) NOT NULL DEFAULT '0' COMMENT '创建人ID',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COMMENT='教学地点表';

-- ----------------------------
-- Records of sky_teachplace
-- ----------------------------
INSERT INTO `sky_teachplace` VALUES ('1', '5教', '5教具体地点', '1512438305', '1514428312', '1', '1');
INSERT INTO `sky_teachplace` VALUES ('2', '5教201', '第5教学楼2楼201教室', '1514426487', '1514428460', '1', '0');
INSERT INTO `sky_teachplace` VALUES ('3', '6教402班', '第6教学楼4楼402教室', '1514428431', '1514428431', '1', '0');
INSERT INTO `sky_teachplace` VALUES ('4', '7教302室', '第7教学楼第3楼302', '1514432624', '1514440699', '1', '0');
INSERT INTO `sky_teachplace` VALUES ('5', '8教403', '第8教学楼4楼403教室', '1514432801', '1514440713', '0', '0');
INSERT INTO `sky_teachplace` VALUES ('6', '9教804', '第9教学楼8楼804教室', '1514432982', '1514433702', '0', '0');
INSERT INTO `sky_teachplace` VALUES ('7', '9教810', '第9教学楼8楼810教室', '1514433098', '1514433671', '0', '0');
INSERT INTO `sky_teachplace` VALUES ('8', '8教505', '第8教学楼5楼505教室', '1514433171', '1514440694', '1', '0');

-- ----------------------------
-- Table structure for `sky_testpaper`
-- ----------------------------
DROP TABLE IF EXISTS `sky_testpaper`;
CREATE TABLE `sky_testpaper` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `title` varchar(200) NOT NULL COMMENT '试卷主题名',
  `questionCount` tinyint(4) NOT NULL DEFAULT '0' COMMENT '试题数',
  `isPublish` tinyint(2) NOT NULL DEFAULT '0' COMMENT '发布状态(0未发布1已发布）',
  `publishCode` varchar(20) DEFAULT NULL COMMENT '发布时间类型',
  `publishTime` int(11) DEFAULT '0' COMMENT '发布时间',
  `verify` tinyint(2) NOT NULL DEFAULT '0' COMMENT '是否审核（0未审核1已审核3审核失败）',
  `verifyReason` varchar(255) DEFAULT '' COMMENT '审核理由',
  `marks` varchar(255) DEFAULT NULL COMMENT '备注',
  `createTime` int(11) NOT NULL COMMENT '创建时间',
  `modifyTime` int(11) NOT NULL COMMENT '编辑时间',
  `createUserId` int(11) NOT NULL DEFAULT '0' COMMENT '创建人ID',
  `createUser` varchar(20) NOT NULL DEFAULT '' COMMENT '创建人账号',
  `isDelete` tinyint(2) NOT NULL DEFAULT '0' COMMENT '是否删除',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COMMENT='试卷表';

-- ----------------------------
-- Records of sky_testpaper
-- ----------------------------
INSERT INTO `sky_testpaper` VALUES ('5', '测试试卷第一卷--编辑', '2', '0', 'oneDay', '1515131467', '0', '', '测试编辑', '1515036959', '1515045067', '0', '', '0');
INSERT INTO `sky_testpaper` VALUES ('6', '测试试卷第二卷-编辑以后', '2', '0', 'oneDay', '1515125606', '0', '', '编辑以后', '1515037172', '1515039207', '0', '', '0');

-- ----------------------------
-- Table structure for `sky_testpaperquestion`
-- ----------------------------
DROP TABLE IF EXISTS `sky_testpaperquestion`;
CREATE TABLE `sky_testpaperquestion` (
  `paperId` int(11) NOT NULL COMMENT '试卷ID',
  `questId` int(11) NOT NULL COMMENT '试题ID',
  `score` tinyint(4) NOT NULL COMMENT '分数',
  `sorts` tinyint(4) NOT NULL COMMENT '排序',
  UNIQUE KEY `ids_paperId_questId` (`paperId`,`questId`) USING BTREE COMMENT '试卷试题唯一'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sky_testpaperquestion
-- ----------------------------
INSERT INTO `sky_testpaperquestion` VALUES ('5', '28', '7', '1');
INSERT INTO `sky_testpaperquestion` VALUES ('5', '31', '5', '2');
INSERT INTO `sky_testpaperquestion` VALUES ('6', '29', '10', '1');
INSERT INTO `sky_testpaperquestion` VALUES ('6', '30', '8', '2');

-- ----------------------------
-- Table structure for `sky_testpaperquestionrecord`
-- ----------------------------
DROP TABLE IF EXISTS `sky_testpaperquestionrecord`;
CREATE TABLE `sky_testpaperquestionrecord` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `anwserMark` varchar(100) NOT NULL COMMENT '答题标识（同一试卷同一批次答题标识一致；重复答题标识不一致）',
  `userId` int(11) NOT NULL COMMENT '用户ID',
  `paperId` int(11) NOT NULL COMMENT '试卷ID',
  `questId` int(11) NOT NULL COMMENT '试题ID',
  `isRight` tinyint(2) NOT NULL DEFAULT '0' COMMENT '是否正确（0否1是）',
  `userAnswer` int(5) NOT NULL DEFAULT '0' COMMENT '用户答案',
  `userAnswerOpt` varchar(50) DEFAULT NULL COMMENT '用户答案选项',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户测评试卷试题答题记录表';

-- ----------------------------
-- Records of sky_testpaperquestionrecord
-- ----------------------------

-- ----------------------------
-- Table structure for `sky_testpaperuserstatistics`
-- ----------------------------
DROP TABLE IF EXISTS `sky_testpaperuserstatistics`;
CREATE TABLE `sky_testpaperuserstatistics` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `userId` int(11) NOT NULL COMMENT '用户ID',
  `account` varchar(50) NOT NULL COMMENT '用户账号',
  `paperId` int(11) NOT NULL COMMENT '试卷ID',
  `anwserMark` varchar(100) NOT NULL COMMENT '答题标识(来源于sky_TestPaperQuestionRecord表）',
  `scores` tinyint(4) NOT NULL DEFAULT '0' COMMENT '总成绩',
  `rightCount` tinyint(4) NOT NULL COMMENT '正确数',
  `rightScores` tinyint(4) NOT NULL COMMENT '正确分数',
  `wrongCount` tinyint(4) NOT NULL COMMENT '错误数量',
  `wrongScores` tinyint(4) NOT NULL COMMENT '错误分数',
  `createTime` int(11) NOT NULL COMMENT '答题时间',
  `modifyTime` int(11) NOT NULL COMMENT '编辑时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户试卷测评数据记录表';

-- ----------------------------
-- Records of sky_testpaperuserstatistics
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
  `roleId` tinyint(4) NOT NULL DEFAULT '1' COMMENT '角色ID',
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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='用户表';

-- ----------------------------
-- Records of sky_user
-- ----------------------------
INSERT INTO `sky_user` VALUES ('1', 'wangtao', '$2y$13$AFviK5lqYQGymP2bQcQUn.4N3UrqaMv5PlqgLVSdwfUoJVtAThByW', '', '623672780@qq.com', '1', '', '', '0', '0', '0', '1512444422', '1514453711');
INSERT INTO `sky_user` VALUES ('2', 'test', '$2y$13$/Kq26g4ks9Peajfc8vi/GOI1ZEk9zdW.JnjgTfqCJ6MMQiccRZTUu', '13648035706', '623672781@qq.com', '1', '', '', '0', '0', '1', '1514450535', '1514452610');
INSERT INTO `sky_user` VALUES ('3', 'test2', '$2y$13$BFnRh0zadd5yz1HNPR1lBOMrdNS1cSNdMrIzufN5ZqAbbGvOQCnjG', '', 'd32423212@qq.com', '1', '', '', '0', '0', '1', '1514452307', '1514452307');

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
  `selectType` enum('radio','multi') NOT NULL DEFAULT 'radio' COMMENT '选择类型（ radio 单选 mulit 多选；默认 radio）',
  `selectCount` tinyint(4) NOT NULL DEFAULT '1' COMMENT '可选数（默认为1；为多选时，不能大于选项总数）',
  `isClose` tinyint(2) NOT NULL DEFAULT '0' COMMENT '是否关闭（0否1是；默认0）',
  `isDelete` tinyint(2) NOT NULL DEFAULT '0' COMMENT '是否删除（0否1是；默认0）',
  `createUserId` int(11) NOT NULL DEFAULT '0' COMMENT '创建人ID（默认0表示系统管理员）',
  `createTime` int(10) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `modifyTime` int(10) NOT NULL DEFAULT '0' COMMENT '编辑时间',
  PRIMARY KEY (`id`),
  KEY `ids_startDate_endDate_isClose_isDelete` (`isClose`,`isDelete`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COMMENT='投票表';

-- ----------------------------
-- Records of sky_vote
-- ----------------------------
INSERT INTO `sky_vote` VALUES ('7', '范德萨范德萨发', '', 'radio', '1', '0', '0', '0', '1515056724', '1515056724');

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
INSERT INTO `sky_voteoptions` VALUES ('发撒发撒发到', '7', '0', '0', '1515056723', '1515056723');
INSERT INTO `sky_voteoptions` VALUES ('范德萨发', '7', '0', '1', '1515056723', '1515056723');

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
