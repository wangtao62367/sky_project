
SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `sky_Admin`
-- ----------------------------
DROP TABLE IF EXISTS `sky_Admin`;
CREATE TABLE `sky_Admin` (
`id`  int(11) NOT NULL AUTO_INCREMENT COMMENT '主键' ,
`account`  varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '管理员账号' ,
`adminPwd`  varchar(150) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '管理员密码' ,
`adminEmail`  varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '邮箱' ,
`department`  varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'admin' COMMENT '所属部门' ,
`loginCount`  int(11) NOT NULL DEFAULT 0 COMMENT '登陆IP' ,
`loginIp`  char(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0' COMMENT '登陆IP' ,
`lastLoginIp`  char(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0' COMMENT '上次登陆IP' ,
`isSuper`  tinyint(2) NOT NULL DEFAULT 0 COMMENT '是否是超级管理员' ,
`isFrozen`  tinyint(2) NOT NULL DEFAULT 0 COMMENT '是否冻结' ,
`createTime`  int(11) NOT NULL DEFAULT 0 COMMENT '创建时间' ,
`modifyTime`  int(11) NOT NULL DEFAULT 0 COMMENT '编辑时间' ,
PRIMARY KEY (`id`)
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci
COMMENT='后台管理系统'
AUTO_INCREMENT=19

;

-- ----------------------------
-- Table structure for `sky_Adv`
-- ----------------------------
DROP TABLE IF EXISTS `sky_Adv`;
CREATE TABLE `sky_Adv` (
`id`  int(11) NOT NULL AUTO_INCREMENT COMMENT '主键' ,
`advs`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '广告词' ,
`imgs`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '广告图' ,
`link`  varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '广告跳转链接' ,
`position`  char(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '广告位置(left/right/top/bottom)' ,
`status`  tinyint(4) NOT NULL COMMENT '状态' ,
`createTime`  int(11) NOT NULL DEFAULT 0 COMMENT '创建时间' ,
`modifyTime`  int(11) NULL DEFAULT 0 COMMENT '编辑时间' ,
PRIMARY KEY (`id`)
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci
COMMENT='广告位表'
AUTO_INCREMENT=21

;

-- ----------------------------
-- Table structure for `sky_Article`
-- ----------------------------
DROP TABLE IF EXISTS `sky_Article`;
CREATE TABLE `sky_Article` (
`id`  int(11) NOT NULL AUTO_INCREMENT COMMENT '主键' ,
`title`  varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '文章标题' ,
`titleImg`  varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '图片标题' ,
`url`  varchar(150) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '文章自定义跳转连接' ,
`author`  varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '作者' ,
`summary`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '文章摘要' ,
`content`  text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '文章内容' ,
`contentCount`  int(11) NOT NULL DEFAULT 0 COMMENT '文章字数' ,
`source`  varchar(150) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '文章来源' ,
`sourceLinke`  varchar(150) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '文章来源链接地址' ,
`readCount`  int(10) NOT NULL DEFAULT 0 COMMENT '预览数' ,
`categoryId`  int(11) NOT NULL DEFAULT 0 COMMENT '文章分类ID' ,
`publishTime`  int(11) NULL DEFAULT 0 COMMENT '发布时间' ,
`publishCode`  varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '发布时间标识' ,
`isPublish`  tinyint(2) NOT NULL DEFAULT 0 COMMENT '是否发布（0否1是）' ,
`isDelete`  tinyint(2) NOT NULL DEFAULT 0 COMMENT '是否删除' ,
`createTime`  int(11) NOT NULL DEFAULT 0 COMMENT '创建时间' ,
`modifyTime`  int(11) NOT NULL DEFAULT 0 COMMENT '编辑时间' ,
`imgCount`  tinyint(4) NOT NULL DEFAULT 0 COMMENT '文章包含的图片数' ,
`imgProvider`  varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '图片提供者' ,
`remarks`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '备注' ,
`leader`  varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '院领导名称' ,
`ishot`  tinyint(2) NOT NULL DEFAULT 0 COMMENT '是否是热点文章' ,
`sorts`  int(10) NOT NULL DEFAULT 999999 COMMENT '排序' ,
`isRecommen`  tinyint(2) NOT NULL DEFAULT 0 COMMENT '是否推荐文章（0否 1是）' ,
PRIMARY KEY (`id`),
INDEX `ids_categoryId_isPublish_isDelete` (`categoryId`, `isPublish`, `isDelete`) USING BTREE ,
INDEX `ids_isPublish_isDelete` (`isPublish`, `isDelete`) USING BTREE 
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci
COMMENT='文章表'
AUTO_INCREMENT=204

;

-- ----------------------------
-- Table structure for `sky_ArticleTag`
-- ----------------------------
DROP TABLE IF EXISTS `sky_ArticleTag`;
CREATE TABLE `sky_ArticleTag` (
`id`  int(11) NOT NULL AUTO_INCREMENT COMMENT '主键' ,
`articleId`  int(11) NOT NULL DEFAULT 0 COMMENT '文章ID' ,
`tagId`  int(11) NOT NULL DEFAULT 0 COMMENT '标签Id' ,
PRIMARY KEY (`id`)
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci
COMMENT='文章标签关系表'
AUTO_INCREMENT=18

;

-- ----------------------------
-- Table structure for `sky_auth_assignment`
-- ----------------------------
DROP TABLE IF EXISTS `sky_auth_assignment`;
CREATE TABLE `sky_auth_assignment` (
`item_name`  varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
`user_id`  varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
`created_at`  int(11) NULL DEFAULT NULL ,
PRIMARY KEY (`item_name`, `user_id`),
FOREIGN KEY (`item_name`) REFERENCES `sky_auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
INDEX `auth_assignment_user_id_idx` (`user_id`) USING BTREE 
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_unicode_ci

;

-- ----------------------------
-- Table structure for `sky_auth_item`
-- ----------------------------
DROP TABLE IF EXISTS `sky_auth_item`;
CREATE TABLE `sky_auth_item` (
`name`  varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
`type`  smallint(6) NOT NULL ,
`description`  text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL ,
`rule_name`  varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL ,
`data`  blob NULL ,
`created_at`  int(11) NULL DEFAULT NULL ,
`updated_at`  int(11) NULL DEFAULT NULL ,
PRIMARY KEY (`name`),
FOREIGN KEY (`rule_name`) REFERENCES `sky_auth_rule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE,
INDEX `rule_name` (`rule_name`) USING BTREE ,
INDEX `idx-auth_item-type` (`type`) USING BTREE 
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_unicode_ci

;

-- ----------------------------
-- Table structure for `sky_auth_item_child`
-- ----------------------------
DROP TABLE IF EXISTS `sky_auth_item_child`;
CREATE TABLE `sky_auth_item_child` (
`parent`  varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
`child`  varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
PRIMARY KEY (`parent`, `child`),
FOREIGN KEY (`parent`) REFERENCES `sky_auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
FOREIGN KEY (`child`) REFERENCES `sky_auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
INDEX `child` (`child`) USING BTREE 
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_unicode_ci

;

-- ----------------------------
-- Table structure for `sky_auth_rule`
-- ----------------------------
DROP TABLE IF EXISTS `sky_auth_rule`;
CREATE TABLE `sky_auth_rule` (
`name`  varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
`data`  blob NULL ,
`created_at`  int(11) NULL DEFAULT NULL ,
`updated_at`  int(11) NULL DEFAULT NULL ,
PRIMARY KEY (`name`)
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_unicode_ci

;

-- ----------------------------
-- Table structure for `sky_BestStudent`
-- ----------------------------
DROP TABLE IF EXISTS `sky_BestStudent`;
CREATE TABLE `sky_BestStudent` (
`id`  int(11) NOT NULL AUTO_INCREMENT COMMENT '主键' ,
`studentId`  int(11) NOT NULL DEFAULT 0 COMMENT '学员ID' ,
`stuIntroduce`  text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '个人介绍' ,
`createTime`  int(11) NOT NULL COMMENT '创建时间' ,
`modifyTime`  int(11) NOT NULL COMMENT '编辑时间' ,
PRIMARY KEY (`id`)
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci
COMMENT='优秀学员表（学员风采表）'
AUTO_INCREMENT=5

;

-- ----------------------------
-- Table structure for `sky_BmRecord`
-- ----------------------------
DROP TABLE IF EXISTS `sky_BmRecord`;
CREATE TABLE `sky_BmRecord` (
`id`  int(11) NOT NULL AUTO_INCREMENT COMMENT '主键' ,
`userId`  int(11) NOT NULL DEFAULT 0 COMMENT '用户ID' ,
`gradeClass`  varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '报名班级' ,
`gradeClassId`  int(11) NOT NULL DEFAULT 0 COMMENT '班级ID' ,
`studyNum`  varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '0000000000000' COMMENT '学号（审核通过后生存）' ,
`verify`  tinyint(4) NOT NULL DEFAULT 1 COMMENT '审核状态（0审核失败1初审2终审3审核完成）' ,
`verifyAdmin1`  int(11) NULL DEFAULT NULL COMMENT '初审人ID' ,
`verifyReason1`  varchar(150) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '初审理由' ,
`verifyTime1`  int(11) NULL DEFAULT 0 COMMENT '初审时间' ,
`verifyAdmin2`  int(11) NULL DEFAULT NULL COMMENT '终审人ID' ,
`verifyReason2`  varchar(150) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '终审理由' ,
`verifyTime2`  int(11) NULL DEFAULT NULL COMMENT '终审时间' ,
`createTime`  int(11) NOT NULL DEFAULT 0 COMMENT '报名时间' ,
`modifyTime`  int(11) NOT NULL DEFAULT 0 COMMENT '修改时间' ,
`trueName`  varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '姓名' ,
`sex`  tinyint(2) NULL DEFAULT 1 COMMENT '性别（1年2女）' ,
`birthday`  date NULL DEFAULT NULL COMMENT '出生年月' ,
`avater`  varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '头像' ,
`political`  varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '党派' ,
`nation`  varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '名族' ,
`nationCode`  varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '名族编号' ,
`health`  tinyint(2) NULL DEFAULT 1 COMMENT '健康状况（1良好2一般3差）' ,
`eduDegree`  varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '文化程度' ,
`speciality`  varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '特长' ,
`dateToWork`  date NULL DEFAULT NULL COMMENT '参加工作的时间' ,
`dateToPolitical`  date NULL DEFAULT NULL COMMENT '参加党派的时间' ,
`politicalGrade`  varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '党派级别' ,
`workplace`  varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '工作单位' ,
`workDuties`  varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '工作职务或职称' ,
`orgCode`  varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '组织机构代码' ,
`IDnumber`  char(18) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '身份证号' ,
`address`  varchar(150) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '通讯地址' ,
`phone`  varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '电话' ,
`postcode`  varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '邮编' ,
`socialDuties`  varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '社会职务' ,
`politicalDuties`  varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '党派职务' ,
`introduction`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '简介' ,
`recommend`  varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '推荐单位' ,
`citystate`  varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '市州' ,
PRIMARY KEY (`id`),
UNIQUE INDEX `ids_userid_gradeclassid` (`userId`, `gradeClassId`) USING BTREE 
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci
COMMENT='报名表'
AUTO_INCREMENT=36

;

-- ----------------------------
-- Table structure for `sky_BottomLink`
-- ----------------------------
DROP TABLE IF EXISTS `sky_BottomLink`;
CREATE TABLE `sky_BottomLink` (
`id`  int(11) NOT NULL AUTO_INCREMENT COMMENT '主键' ,
`linkName`  varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '链接名称' ,
`linkImg`  varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '链接图标' ,
`linkUrl`  varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '链接URL地址' ,
`linkCateId`  int(10) NOT NULL DEFAULT 0 COMMENT '链接类型' ,
`sorts`  int(10) NOT NULL DEFAULT 999999 COMMENT '排序' ,
`createTime`  int(11) NOT NULL DEFAULT 0 COMMENT '创建时间' ,
`modifyTime`  int(11) NOT NULL DEFAULT 0 COMMENT '编辑时间' ,
PRIMARY KEY (`id`),
INDEX `ids_linkCateId` (`linkCateId`) USING BTREE 
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci
COMMENT='友情链接表'
AUTO_INCREMENT=76

;

-- ----------------------------
-- Table structure for `sky_Carousel`
-- ----------------------------
DROP TABLE IF EXISTS `sky_Carousel`;
CREATE TABLE `sky_Carousel` (
`id`  int(11) NOT NULL AUTO_INCREMENT COMMENT '主键' ,
`img`  varchar(150) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '轮播图片' ,
`link`  varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '链接地址' ,
`title`  varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '轮播标题说明' ,
`sorts`  int(10) NOT NULL DEFAULT 100000 COMMENT '排序（数字越小越靠前）' ,
`createTime`  int(11) NOT NULL DEFAULT 0 COMMENT '创建时间' ,
`modifyTime`  int(11) NOT NULL DEFAULT 0 COMMENT '编辑时间' ,
PRIMARY KEY (`id`)
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci
COMMENT='首页轮播配置表'
AUTO_INCREMENT=23

;

-- ----------------------------
-- Table structure for `sky_Category`
-- ----------------------------
DROP TABLE IF EXISTS `sky_Category`;
CREATE TABLE `sky_Category` (
`id`  int(11) NOT NULL AUTO_INCREMENT COMMENT '主键' ,
`text`  varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '分类名称' ,
`cateCode`  varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '分类标识' ,
`parentId`  int(11) NOT NULL DEFAULT 0 COMMENT '父级ID' ,
`createTime`  int(11) NOT NULL DEFAULT 0 COMMENT '创建时间' ,
`modifyTime`  int(11) NOT NULL DEFAULT 0 COMMENT '编辑时间' ,
`descr`  varchar(150) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '分类描述' ,
`positions`  enum('top','hot','normal') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'normal' COMMENT '首页位置（top顶部、hot热点位置、normal正常位置）' ,
`type`  enum('video','image','file','orther','article') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'article' COMMENT '分类类型' ,
`isDelete`  tinyint(2) NOT NULL DEFAULT 0 COMMENT '是否删除（0是1否）' ,
`isBase`  tinyint(2) NOT NULL DEFAULT 0 COMMENT '是否是基础分类（1是，不能删除；0否，可以删除）' ,
`creatAdminId`  int(11) NOT NULL DEFAULT 0 COMMENT '创建人ID' ,
PRIMARY KEY (`id`),
INDEX `ids_isDelete` (`isDelete`) USING BTREE 
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci
COMMENT='文章分类表'
AUTO_INCREMENT=83

;

INSERT INTO `sky_Category` VALUES ('12', '名师堂', 'mmst', '23', '1516327044', '1516327044', '', 'normal', 'orther', '0', '1', '0');
INSERT INTO `sky_Category` VALUES ('13', '市州社院', 'szsy', '5', '1516327044', '1516327044', '', 'normal', 'article', '0', '1', '0');
INSERT INTO `sky_Category` VALUES ('14', '学院简介', 'xyjj', '4', '1516327044', '1516327044', '本学院的基本简介', 'normal', 'orther', '0', '1', '0');
INSERT INTO `sky_Category` VALUES ('15', '发展历程', 'fzlc', '4', '1516327080', '1516327080', '本学院的发展历程介绍', 'normal', 'orther', '0', '1', '0');
INSERT INTO `sky_Category` VALUES ('16', '师资情况', 'szqk', '4', '1516327131', '1516327131', '本学院师资情况介绍', 'normal', 'orther', '0', '1', '0');
INSERT INTO `sky_Category` VALUES ('17', '组织机构', 'zzjg', '4', '1516327163', '1523323415', '本学院组织机构介绍信息', 'normal', 'orther', '0', '1', '0');
INSERT INTO `sky_Category` VALUES ('18', '现任领导', 'xrld', '4', '1516327209', '1516327209', '本学院现任领导基本介绍', 'normal', 'orther', '0', '1', '0');
INSERT INTO `sky_Category` VALUES ('19', '客座教授', 'kzjs', '4', '1516327243', '1520492990', '本学院的客座教授基本介绍', 'normal', 'orther', '0', '1', '0');
INSERT INTO `sky_Category` VALUES ('20', '社院风采', 'syfc', '4', '1516327271', '1516327271', '本学院的社院风采', 'normal', 'orther', '0', '1', '0');
INSERT INTO `sky_Category` VALUES ('21', '校园风光', 'xyfg', '4', '1516327884', '1516327884', '本学院校园风光', 'normal', 'image', '0', '1', '0');
INSERT INTO `sky_Category` VALUES ('22', '学院地址', 'xydz', '4', '1516327911', '1516327911', '本学院学院地址', 'normal', 'orther', '0', '1', '0');
INSERT INTO `sky_Category` VALUES ('23', '统战新闻', 'tzxw', '5', '1516328011', '1516328011', '', 'normal', 'article', '0', '1', '0');
INSERT INTO `sky_Category` VALUES ('24', '社院新闻', 'syxw', '5', '1516328036', '1516328036', '', 'normal', 'article', '0', '1', '0');
INSERT INTO `sky_Category` VALUES ('25', '时政要闻', 'szyw', '5', '1516328106', '1516328106', '', 'normal', 'article', '0', '1', '0');
INSERT INTO `sky_Category` VALUES ('26', '公告通知', 'ggtz', '5', '1516328197', '1516328197', '', 'normal', 'article', '0', '1', '0');
INSERT INTO `sky_Category` VALUES ('27', '视讯社院', 'sxsy', '5', '1516328324', '1516328324', '', 'normal', 'video', '0', '1', '0');
INSERT INTO `sky_Category` VALUES ('28', '教学信息', 'jxxx', '6', '1516328374', '1516328374', '', 'normal', 'article', '0', '1', '0');
INSERT INTO `sky_Category` VALUES ('29', '课表查询', 'kbcx', '6', '1516328420', '1516328420', '', 'normal', 'orther', '0', '1', '0');
INSERT INTO `sky_Category` VALUES ('30', '微课中心', 'wkzx', '6', '1516328450', '1516328450', '', 'normal', 'video', '0', '1', '0');
INSERT INTO `sky_Category` VALUES ('31', '科研成果', 'kycg', '7', '1516328501', '1516328501', '', 'normal', 'article', '0', '1', '0');
INSERT INTO `sky_Category` VALUES ('32', '科研信息', 'kyxx', '7', '1516328559', '1516328559', '', 'normal', 'article', '0', '1', '0');
INSERT INTO `sky_Category` VALUES ('33', '文化交流', 'whjl', '8', '1516328829', '1516328829', '', 'normal', 'article', '0', '1', '0');
INSERT INTO `sky_Category` VALUES ('34', '文化论坛', 'whlt', '8', '1516328884', '1516328884', '', 'normal', 'article', '0', '1', '0');
INSERT INTO `sky_Category` VALUES ('35', '学员风采', 'xyfc', '9', '1516328936', '1516328936', '本学院的学员风采', 'normal', 'orther', '0', '1', '0');
INSERT INTO `sky_Category` VALUES ('36', '学员活动', 'xyhd', '9', '1516328970', '1516328970', '本学院的学员活动展示', 'normal', 'article', '0', '1', '0');
INSERT INTO `sky_Category` VALUES ('37', '智库简介', 'zkzx', '10', '1516328998', '1516328998', '', 'normal', 'orther', '0', '1', '0');
INSERT INTO `sky_Category` VALUES ('38', '信息动态', 'xxdt', '10', '1516329051', '1516329051', '', 'normal', 'article', '0', '1', '0');
INSERT INTO `sky_Category` VALUES ('41', '软件包', null, '11', '1516775370', '1516775370', '', 'normal', 'file', '0', '0', '0');
INSERT INTO `sky_Category` VALUES ('42', '党群行政', 'dqxz', '13', '1517378562', '1517378562', '', 'normal', 'article', '0', '1', '0');
INSERT INTO `sky_Category` VALUES ('44', '我要报名', 'wybm', '6', '1518166760', '1518166760', '', 'normal', 'orther', '0', '1', '0');
INSERT INTO `sky_Category` VALUES ('45', '投票调查', 'tpdc', '6', '1518166784', '1518166784', '', 'normal', 'orther', '0', '1', '0');
INSERT INTO `sky_Category` VALUES ('47', '量子力学', null, '7', '1519973125', '1520301323', '', 'normal', 'article', '1', '0', '0');
INSERT INTO `sky_Category` VALUES ('48', '群众路线', null, '13', '1520301247', '1520301247', '发的发的', 'normal', 'article', '0', '0', '0');
INSERT INTO `sky_Category` VALUES ('49', '589', null, '4', '1520491771', '1522153749', 'vbvb', 'normal', 'article', '1', '0', '0');
INSERT INTO `sky_Category` VALUES ('50', '675', null, '13', '1520491863', '1522153832', 'dsdsa', 'normal', 'article', '1', '0', '0');
INSERT INTO `sky_Category` VALUES ('51', 'cxv', null, '10', '1520491945', '1522153808', 'v ', 'normal', 'video', '1', '0', '0');
INSERT INTO `sky_Category` VALUES ('52', 'fdas', null, '12', '1520491978', '1520926849', 'dsf', 'normal', 'image', '1', '0', '0');
INSERT INTO `sky_Category` VALUES ('53', 'fdfd', null, '4', '1520492448', '1520926843', 'ghggfh65436', 'normal', 'article', '1', '0', '0');
INSERT INTO `sky_Category` VALUES ('54', '文化课堂', 'whkt', '8', '1520926168', '1520926773', '', 'normal', 'article', '0', '1', '0');
INSERT INTO `sky_Category` VALUES ('55', '理论研究', 'llyj', '8', '1520926880', '1520926880', '', 'normal', 'article', '0', '1', '0');
INSERT INTO `sky_Category` VALUES ('56', '社院学报', null, '7', '1522505127', '1533951965', '对方公司的', 'normal', 'article', '1', '0', '0');
INSERT INTO `sky_Category` VALUES ('57', '34455', null, '4', '1522506352', '1522726146', '', 'normal', 'article', '1', '0', '0');
INSERT INTO `sky_Category` VALUES ('58', '344222222222255', null, '14', '1522506562', '1522726142', 'ef', 'normal', 'file', '1', '0', '0');
INSERT INTO `sky_Category` VALUES ('59', 'test', null, '5', '1522507601', '1522726140', '', 'normal', 'article', '1', '0', '0');
INSERT INTO `sky_Category` VALUES ('60', 'yyyyy', null, '11', '1522551358', '1522726143', '', 'normal', 'file', '1', '0', '0');
INSERT INTO `sky_Category` VALUES ('61', 'testMP4', null, '6', '1522553604', '1522624305', '', 'normal', 'video', '1', '0', '0');
INSERT INTO `sky_Category` VALUES ('62', '563', null, '10', '1522553795', '1522624295', '收到', 'normal', 'image', '1', '0', '0');
INSERT INTO `sky_Category` VALUES ('63', '563', null, '10', '1522553795', '1522624299', '收到', 'normal', 'image', '1', '0', '0');
INSERT INTO `sky_Category` VALUES ('64', '哇哇哇哇', null, '4', '1522563746', '1522624292', '', 'normal', 'article', '1', '0', '0');
INSERT INTO `sky_Category` VALUES ('65', '亲切关怀', null, '4', '1522624226', '1522624226', '', 'normal', 'image', '0', '0', '0');
INSERT INTO `sky_Category` VALUES ('66', '院务委员会', null, '4', '1522726134', '1522756469', '', 'normal', 'image', '0', '0', '0');
INSERT INTO `sky_Category` VALUES ('67', '测试分类', null, '5', '1522763992', '1527059439', '', 'normal', 'article', '1', '0', '0');
INSERT INTO `sky_Category` VALUES ('68', '资料下载', 'zlxz', '11', '1522805091', '1527060351', '学习资料等下载', 'normal', 'file', '0', '1', '0');
INSERT INTO `sky_Category` VALUES ('69', 'testd', null, '7', '1522808041', '1523067214', '第三方', 'normal', 'article', '1', '0', '0');
INSERT INTO `sky_Category` VALUES ('70', 'testff\'', null, '13', '1522808322', '1523067217', '大幅放大', 'normal', 'image', '1', '0', '0');
INSERT INTO `sky_Category` VALUES ('71', '多方', null, '6', '1522808496', '1523323379', '多方', 'normal', 'video', '1', '0', '0');
INSERT INTO `sky_Category` VALUES ('72', '教育基地', null, '4', '1523081146', '1533950228', '四川省社会主义学院爱国主义教育基地', 'normal', 'article', '1', '0', '0');
INSERT INTO `sky_Category` VALUES ('73', '测试分类43', null, '10', '1523611418', '1523611613', '', 'normal', 'file', '1', '0', '0');
INSERT INTO `sky_Category` VALUES ('74', '党群建设35434', null, '11', '1523611666', '1523611681', '', 'normal', 'file', '1', '0', '0');
INSERT INTO `sky_Category` VALUES ('75', '影像社院', null, '9', '1523765684', '1527823045', '', 'normal', 'video', '1', '0', '0');
INSERT INTO `sky_Category` VALUES ('76', '测试分类3', null, '11', '1523850399', '1527059399', '', 'normal', 'file', '1', '0', '0');
INSERT INTO `sky_Category` VALUES ('77', '信息化建设', 'xxhjs', '12', '1527059101', '1527059264', '', 'normal', 'article', '0', '0', '0');
INSERT INTO `sky_Category` VALUES ('78', '统一战线故事', null, '8', '1530150776', '1530846547', '', 'normal', 'article', '1', '0', '0');
INSERT INTO `sky_Category` VALUES ('79', '统战故事', 'tzgs', '8', '1530846432', '1530846432', '', 'normal', 'article', '0', '1', '0');
INSERT INTO `sky_Category` VALUES ('80', '文学书画', 'wxsh', '8', '1530846458', '1530846458', '', 'normal', 'article', '0', '1', '0');
INSERT INTO `sky_Category` VALUES ('81', '前沿新闻', 'qyxw', '14', '1530846432', '1530846432', '', 'normal', 'article', '0', '1', '0');
INSERT INTO `sky_Category` VALUES ('82', 'testA', null, '4', '1533952078', '1533952078', '', 'normal', 'article', '0', '0', '0');

-- ----------------------------
-- Table structure for `sky_Common`
-- ----------------------------
DROP TABLE IF EXISTS `sky_Common`;
CREATE TABLE `sky_Common` (
`id`  int(11) NOT NULL AUTO_INCREMENT COMMENT '主键' ,
`code`  varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '配置标识' ,
`codeDesc`  varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '配置描述' ,
`type`  varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '配置类型（同一类型值一样）' ,
`typeDesc`  varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
`sorts`  int(10) NOT NULL DEFAULT 9999999 COMMENT '排序(顺序排,越大越靠后）' ,
`modifyTime`  int(11) NOT NULL DEFAULT 0 COMMENT '编辑时间' ,
`createTime`  int(11) NOT NULL DEFAULT 0 COMMENT '添加时间' ,
`isDelete`  tinyint(4) NOT NULL DEFAULT 0 COMMENT '是否删除' ,
`isShow`  tinyint(2) NOT NULL DEFAULT 1 COMMENT '是否显示（1显示0不显示）' ,
PRIMARY KEY (`id`)
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci
COMMENT='常用配置表'
AUTO_INCREMENT=24

;

-- ----------------------------
-- Records of sky_Common
-- ----------------------------
INSERT INTO `sky_Common` VALUES ('1', 'friendship', '统战系统', 'bottomLink', '底部链接', '1', '1526435974', '0', '0', '1');
INSERT INTO `sky_Common` VALUES ('2', 'sylink', '兄弟社院', 'bottomLink', '底部链接', '2', '1526435957', '0', '0', '1');
INSERT INTO `sky_Common` VALUES ('3', 'dflink', '市州社院', 'bottomLink', '底部链接', '4', '1523081063', '0', '0', '1');
INSERT INTO `sky_Common` VALUES ('4', 'school', '学院概况', 'navigation', '首页导航', '1', '1522624241', '0', '0', '1');
INSERT INTO `sky_Common` VALUES ('5', 'news', '新闻活动', 'navigation', '首页导航', '2', '1532574147', '0', '0', '1');
INSERT INTO `sky_Common` VALUES ('6', 'jxpx', '教学培训', 'navigation', '首页导航', '3', '0', '0', '0', '1');
INSERT INTO `sky_Common` VALUES ('7', 'kydt', '科研动态', 'navigation', '首页导航', '6', '1532574190', '0', '0', '1');
INSERT INTO `sky_Common` VALUES ('8', 'whxy', '文化交流', 'navigation', '首页导航', '5', '1532574169', '0', '0', '1');
INSERT INTO `sky_Common` VALUES ('9', 'xytd', '学员园地', 'navigation', '首页导航', '7', '1532574217', '0', '0', '1');
INSERT INTO `sky_Common` VALUES ('10', 'zkzx', '智库中心', 'navigation', '首页导航', '9', '0', '0', '0', '1');
INSERT INTO `sky_Common` VALUES ('11', 'xzzx', '下载中心', 'navigation', '首页导航', '10', '1532680110', '0', '0', '1');
INSERT INTO `sky_Common` VALUES ('12', 'xxhjs', '信息化建设', 'navigation', '首页导航', '11', '1532680099', '0', '0', '0');
INSERT INTO `sky_Common` VALUES ('13', 'dqjs', '党群建设', 'navigation', '首页导航', '5', '1522513720', '0', '0', '1');
INSERT INTO `sky_Common` VALUES ('14', 'llqy', '理论前沿', 'navigation', '首页导航', '8', '0', '0', '0', '1');
INSERT INTO `sky_Common` VALUES ('15', 'xrld', '现任领导', 'personage', '社院人物', '0', '0', '0', '0', '1');
INSERT INTO `sky_Common` VALUES ('16', 'kzjs', '做客教授', 'personage', '社院人物', '0', '0', '0', '0', '1');
INSERT INTO `sky_Common` VALUES ('17', 'csdb', '测试底部', 'bottomLink', '底部链接', '999999', '1520590116', '1520589086', '1', '1');
INSERT INTO `sky_Common` VALUES ('18', 'csdb3', '测试底3', 'bottomLink', '底部链接', '4', '1520590383', '1520590197', '1', '1');
INSERT INTO `sky_Common` VALUES ('19', '的说法', '兄弟社院', 'bottomLink', '底部链接', '1', '1523761234', '1522505672', '1', '1');
INSERT INTO `sky_Common` VALUES ('20', 'wwww', '22222', 'bottomLink', '底部链接', '1', '1522728576', '1522505918', '1', '1');
INSERT INTO `sky_Common` VALUES ('21', 'szqk', '师资情况', 'personage', '社院人物', '0', '0', '0', '0', '1');
INSERT INTO `sky_Common` VALUES ('22', 'xyfc', '学员风采', 'personage', '社院人物', '0', '0', '0', '0', '1');
INSERT INTO `sky_Common` VALUES ('23', 'mst', '名 师 堂', 'navigation', '首页导航', '4', '1533373408', '0', '0', '1');

-- ----------------------------
-- Table structure for `sky_Curriculum`
-- ----------------------------
DROP TABLE IF EXISTS `sky_Curriculum`;
CREATE TABLE `sky_Curriculum` (
`id`  int(11) NOT NULL AUTO_INCREMENT COMMENT '主键' ,
`text`  varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '课程名称' ,
`period`  tinyint(4) NOT NULL DEFAULT 0 COMMENT '课时' ,
`isRequired`  tinyint(2) NOT NULL DEFAULT 0 COMMENT '是否必修' ,
`remarks`  varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '备注' ,
`isDelete`  tinyint(2) NOT NULL DEFAULT 0 COMMENT '是否删除（0否1是；默认0）' ,
`createTime`  int(10) NOT NULL DEFAULT 0 COMMENT '创建时间' ,
`modifyTime`  int(10) NOT NULL DEFAULT 0 COMMENT '编辑时间' ,
PRIMARY KEY (`id`)
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci
COMMENT='课程表'
AUTO_INCREMENT=13

;

-- ----------------------------
-- Table structure for `sky_Download`
-- ----------------------------
DROP TABLE IF EXISTS `sky_Download`;
CREATE TABLE `sky_Download` (
`id`  int(11) NOT NULL AUTO_INCREMENT COMMENT '主键' ,
`descr`  varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '文件名称' ,
`uri`  varchar(150) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '下载地址' ,
`createTime`  int(11) NOT NULL DEFAULT 0 COMMENT '创建时间' ,
`modifyTime`  int(11) NOT NULL COMMENT '编辑时间' ,
`categoryId`  int(11) NOT NULL DEFAULT 0 COMMENT '文件分类' ,
`remarks`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '备注信息' ,
`provider`  varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '提供者' ,
`leader`  varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '院领导' ,
`loadCount`  int(11) NULL DEFAULT 0 COMMENT '下载量' ,
PRIMARY KEY (`id`)
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci
COMMENT='下载中心表'
AUTO_INCREMENT=22

;

-- ----------------------------
-- Table structure for `sky_EducationBase`
-- ----------------------------
DROP TABLE IF EXISTS `sky_EducationBase`;
CREATE TABLE `sky_EducationBase` (
`id`  int(11) NOT NULL AUTO_INCREMENT COMMENT '主键' ,
`baseName`  varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '教育基地名称' ,
`baseImg`  varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '基地图片' ,
`link`  varchar(150) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '跳转连接' ,
`sorts`  int(10) NOT NULL DEFAULT 100000 COMMENT '排序' ,
`createTime`  int(11) NOT NULL DEFAULT 0 COMMENT '创建时间' ,
`modifyTime`  int(11) NOT NULL DEFAULT 0 COMMENT '编辑时间' ,
PRIMARY KEY (`id`)
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci
COMMENT='特色教育基地表'
AUTO_INCREMENT=29

;

-- ----------------------------
-- Table structure for `sky_FamousTeacher`
-- ----------------------------
DROP TABLE IF EXISTS `sky_FamousTeacher`;
CREATE TABLE `sky_FamousTeacher` (
`id`  int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '主键' ,
`name`  varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '姓名' ,
`avater`  varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '头像' ,
`teach`  varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '授课内容' ,
`intro`  text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '个人简介' ,
`sorts`  int(10) UNSIGNED NOT NULL DEFAULT 999999 COMMENT '排序' ,
`createTime`  int(11) NOT NULL DEFAULT 0 COMMENT '添加时间' ,
`modifyTime`  int(11) NOT NULL DEFAULT 0 COMMENT '编辑时间' ,
`isDelete`  tinyint(2) UNSIGNED NOT NULL DEFAULT 0 COMMENT '是否删除' ,
PRIMARY KEY (`id`)
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci
COMMENT='名师堂表'
AUTO_INCREMENT=9

;

-- ----------------------------
-- Table structure for `sky_GradeClass`
-- ----------------------------
DROP TABLE IF EXISTS `sky_GradeClass`;
CREATE TABLE `sky_GradeClass` (
`id`  int(11) NOT NULL AUTO_INCREMENT COMMENT '主键' ,
`className`  varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '班级名称' ,
`classSize`  int(4) NOT NULL DEFAULT 0 COMMENT '班人数' ,
`joinStartDate`  date NULL DEFAULT NULL COMMENT '报名开始时间' ,
`joinEndDate`  date NULL DEFAULT NULL COMMENT '报名介绍时间' ,
`createTime`  int(11) NOT NULL DEFAULT 0 COMMENT '创建时间' ,
`modifyTime`  int(11) NOT NULL DEFAULT 0 COMMENT '编辑时间' ,
`isDelete`  tinyint(2) NOT NULL DEFAULT 0 COMMENT '是否删除' ,
`createAdminId`  int(11) NOT NULL DEFAULT 0 COMMENT '创建人Id' ,
`remarks`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '备注信息' ,
`contact`  varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '联络人' ,
`phone`  char(11) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '联系电话' ,
`eduAdmin`  varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '教务员' ,
`eduAdminPhone`  char(11) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '教务员联系电话' ,
`mediaAdmin`  varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '多媒体管理员' ,
`mediaAdminPhone`  char(11) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '多媒体管理员电话' ,
`openClassTime`  date NOT NULL DEFAULT '0000-00-00' COMMENT '开班时间' ,
`openClassLeader`  varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '出席开班时 院领导' ,
`closeClassTime`  date NOT NULL COMMENT '结业时间' ,
`closeClassLeader`  varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '出席结业时院领导' ,
`currentTeachs`  tinyint(4) NULL DEFAULT NULL COMMENT '本院教师任课节数' ,
`invitTeachs`  tinyint(4) NULL DEFAULT NULL COMMENT '外聘教师任课节数' ,
`periods`  tinyint(4) NULL DEFAULT 1 COMMENT '期数' ,
PRIMARY KEY (`id`)
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci
COMMENT='班级表'
AUTO_INCREMENT=17

;

-- ----------------------------
-- Table structure for `sky_migration`
-- ----------------------------
DROP TABLE IF EXISTS `sky_migration`;
CREATE TABLE `sky_migration` (
`version`  varchar(180) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
`apply_time`  int(11) NULL DEFAULT NULL ,
PRIMARY KEY (`version`)
)
ENGINE=MyISAM
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci

;

-- ----------------------------
-- Table structure for `sky_Naire`
-- ----------------------------
DROP TABLE IF EXISTS `sky_Naire`;
CREATE TABLE `sky_Naire` (
`id`  int(11) NOT NULL AUTO_INCREMENT COMMENT '主键' ,
`title`  varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '调查主题' ,
`voteCount`  tinyint(4) NOT NULL COMMENT '调查卷内投票试题数' ,
`isPublish`  tinyint(2) NOT NULL DEFAULT 0 COMMENT '是否发布' ,
`marks`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '备注' ,
`isDelete`  tinyint(2) NOT NULL DEFAULT 0 COMMENT '是否删除' ,
`createTime`  int(11) NOT NULL COMMENT '创建时间' ,
`modifyTime`  int(11) NOT NULL COMMENT '修改时间' ,
PRIMARY KEY (`id`)
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci
COMMENT='问卷调查表'
AUTO_INCREMENT=17

;

-- ----------------------------
-- Table structure for `sky_NaireVote`
-- ----------------------------
DROP TABLE IF EXISTS `sky_NaireVote`;
CREATE TABLE `sky_NaireVote` (
`naireId`  int(11) NOT NULL COMMENT '调查试卷ID' ,
`voteId`  int(11) NOT NULL COMMENT '调查试题表' ,
`sorts`  tinyint(4) NOT NULL DEFAULT 1 COMMENT '排序' ,
UNIQUE INDEX `ids_naireId_voteId` (`naireId`, `voteId`) USING BTREE 
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci
COMMENT='调查试卷与调查题关系表'

;

-- ----------------------------
-- Table structure for `sky_NavreLation`
-- ----------------------------
DROP TABLE IF EXISTS `sky_NavreLation`;
CREATE TABLE `sky_NavreLation` (
`navId`  int(11) NOT NULL COMMENT '导航Id' ,
`cateId`  int(11) NOT NULL COMMENT '分类Id' 
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci

;

-- ----------------------------
-- Table structure for `sky_Organization`
-- ----------------------------
DROP TABLE IF EXISTS `sky_Organization`;
CREATE TABLE `sky_Organization` (
`id`  int(11) NOT NULL AUTO_INCREMENT COMMENT '主键' ,
`name`  varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '机构名称' ,
`contacts`  varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '联系人' ,
`phone`  varchar(15) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '电话' ,
PRIMARY KEY (`id`)
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci
COMMENT='组织机构表'
AUTO_INCREMENT=1

;

-- ----------------------------
-- Table structure for `sky_Personage`
-- ----------------------------
DROP TABLE IF EXISTS `sky_Personage`;
CREATE TABLE `sky_Personage` (
`id`  int(11) NOT NULL AUTO_INCREMENT COMMENT '主键' ,
`fullName`  varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '姓名' ,
`photo`  varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
`duties`  varchar(150) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '职务描述' ,
`intruduce`  text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '个人简介' ,
`role`  varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '人物角色' ,
`createTime`  int(11) NOT NULL DEFAULT 0 COMMENT '创建时间' ,
`modifyTime`  int(11) NOT NULL DEFAULT 0 COMMENT '编辑时间' ,
PRIMARY KEY (`id`)
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci
COMMENT='社科院人物表(包括：做客教授、现任领导、师资情况、学员风采)'
AUTO_INCREMENT=21

;

-- ----------------------------
-- Table structure for `sky_Photo`
-- ----------------------------
DROP TABLE IF EXISTS `sky_Photo`;
CREATE TABLE `sky_Photo` (
`id`  int(11) NOT NULL AUTO_INCREMENT COMMENT '主键' ,
`photo`  varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '图片' ,
`categoryId`  int(10) NOT NULL COMMENT '图片分类' ,
`title`  varchar(150) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '图片标题' ,
`link`  varchar(150) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '图片跳转连接' ,
`provider`  varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '提供者' ,
`leader`  varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '领导' ,
`remarks`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '备注' ,
`isDelete`  tinyint(2) NOT NULL DEFAULT 0 COMMENT '是否删除' ,
`createTime`  int(11) NOT NULL DEFAULT 0 COMMENT '创建时间' ,
`modifyTime`  int(11) NOT NULL DEFAULT 0 COMMENT '修改时间' ,
PRIMARY KEY (`id`)
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci
COMMENT='图讯社园表'
AUTO_INCREMENT=50

;

-- ----------------------------
-- Table structure for `sky_Profile`
-- ----------------------------
DROP TABLE IF EXISTS `sky_Profile`;
CREATE TABLE `sky_Profile` (
`id`  int(11) NOT NULL AUTO_INCREMENT COMMENT '主键' ,
`userId`  int(11) NOT NULL COMMENT '用户ID' ,
`trueName`  varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '真实姓名' ,
`avater`  varchar(150) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '用户头像地址' ,
`sex`  tinyint(2) NOT NULL DEFAULT 0 COMMENT '性别（0未知1男2女；默认为0）' ,
`IDnumber`  char(18) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '身份证号' ,
`birthday`  date NOT NULL COMMENT '出生年月' ,
`nation`  varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '名族' ,
`nationCode`  varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '01' COMMENT '名族编码' ,
`city`  varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '现居城市' ,
`address`  varchar(150) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '联系地址' ,
`phone`  char(11) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '联系电话' ,
`company`  varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '工作单位（公司）' ,
`workYear`  tinyint(3) NOT NULL DEFAULT 0 COMMENT '工作年限' ,
`graduationSchool`  varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '毕业学校' ,
`graduationMajor`  varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '毕业专业' ,
`positionalTitles`  varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '职称' ,
`eduationCode`  varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '01' COMMENT '学历标识' ,
`eduation`  varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '学历' ,
`politicalStatusCode`  varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '01' COMMENT '政治面貌标识' ,
`politicalStatus`  varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '政治面貌' ,
`currentMajor`  char(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '社院所学专业' ,
`selfIntruduce`  varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '个人简历' ,
`isDelete`  tinyint(2) NOT NULL DEFAULT 0 COMMENT '是否删除' ,
`isBest`  tinyint(2) NOT NULL DEFAULT 0 COMMENT '是否是优秀学员' ,
`createTime`  int(11) NOT NULL COMMENT '创建时间' ,
`modifyTime`  int(11) NOT NULL COMMENT '编辑时间' ,
PRIMARY KEY (`id`),
INDEX `ids_userId` (`userId`) USING BTREE 
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci
COMMENT='用户信息表'
AUTO_INCREMENT=12

;

-- ----------------------------
-- Table structure for `sky_Question`
-- ----------------------------
DROP TABLE IF EXISTS `sky_Question`;
CREATE TABLE `sky_Question` (
`id`  int(11) NOT NULL AUTO_INCREMENT COMMENT '主键' ,
`title`  varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '标题' ,
`titleImg`  varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '图片标题' ,
`cate`  enum('radio','multi','trueOrfalse','unknow') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'unknow' COMMENT '试题类型（radio单选multi多选trueOrfalse判断题unknow未知）' ,
`answer`  int(5) NOT NULL DEFAULT 0 COMMENT '正确答案' ,
`answerOpt`  varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '正确选项' ,
`isDelete`  tinyint(2) NOT NULL DEFAULT 0 COMMENT '是否删除' ,
`createTime`  int(11) NOT NULL DEFAULT 0 COMMENT '创建时间' ,
`modifyTime`  int(11) NULL DEFAULT 0 COMMENT '编辑时间' ,
PRIMARY KEY (`id`)
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci
COMMENT='微课试题表'
AUTO_INCREMENT=73

;

-- ----------------------------
-- Table structure for `sky_QuestOptions`
-- ----------------------------
DROP TABLE IF EXISTS `sky_QuestOptions`;
CREATE TABLE `sky_QuestOptions` (
`questId`  int(11) NOT NULL DEFAULT 0 COMMENT '试题ID' ,
`opt`  varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '选项' ,
`optImg`  varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '图片选项' ,
`sorts`  tinyint(4) NOT NULL DEFAULT 0 COMMENT '选项排序' ,
PRIMARY KEY (`questId`, `sorts`),
INDEX `ids_questId` (`questId`) USING BTREE 
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci
COMMENT='试题选项表 （只针对选择题才会存在选项）'

;

-- ----------------------------
-- Table structure for `sky_Role`
-- ----------------------------
DROP TABLE IF EXISTS `sky_Role`;
CREATE TABLE `sky_Role` (
`id`  int(11) NOT NULL AUTO_INCREMENT COMMENT '主键' ,
`roleName`  char(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '角色名称' ,
PRIMARY KEY (`id`)
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci
COMMENT='角色表'
AUTO_INCREMENT=4

;

-- ----------------------------
-- Table structure for `sky_Schedule`
-- ----------------------------
DROP TABLE IF EXISTS `sky_Schedule`;
CREATE TABLE `sky_Schedule` (
`id`  int(11) NOT NULL AUTO_INCREMENT COMMENT '主键' ,
`title`  varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '课表主题' ,
`gradeClassId`  int(11) NOT NULL COMMENT '授课班级ID' ,
`gradeClass`  varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '班级名称' ,
`isPublish`  tinyint(2) NOT NULL DEFAULT 0 COMMENT '是否发布（0否1是）' ,
`publishTime`  int(11) NULL DEFAULT 0 COMMENT '发布时间' ,
`publishCode`  varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '发布时间类型标识' ,
`publishEndTime`  int(11) NOT NULL DEFAULT 0 COMMENT '发布结束时间（时间已过自动删除）' ,
`isDelete`  tinyint(2) NOT NULL DEFAULT 0 COMMENT '是否删除（0否1是）' ,
`marks`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '备注信息' ,
`createTime`  int(11) NOT NULL DEFAULT 0 COMMENT '创建时间' ,
`modifyTime`  int(11) NOT NULL DEFAULT 0 COMMENT '编辑时间' ,
PRIMARY KEY (`id`),
INDEX `ids_curriculumId_teacherId_teachPlaceId_gradeClassId_isPublish` (`isPublish`) USING BTREE 
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci
COMMENT='学院课表表'
AUTO_INCREMENT=21

;

-- ----------------------------
-- Table structure for `sky_ScheduleTable`
-- ----------------------------
DROP TABLE IF EXISTS `sky_ScheduleTable`;
CREATE TABLE `sky_ScheduleTable` (
`id`  int(11) NOT NULL AUTO_INCREMENT COMMENT '主键' ,
`scheduleId`  int(11) NOT NULL COMMENT '课表ID' ,
`curriculumId`  int(11) NOT NULL COMMENT '课程ID' ,
`curriculumText`  varchar(150) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '课程名称' ,
`teacherId`  int(11) NOT NULL COMMENT '教师ID' ,
`teacherName`  varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '教师名称' ,
`teachPlaceId`  int(11) NOT NULL COMMENT '教学点ID' ,
`teachPlace`  varchar(150) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '教学点' ,
`lessonDate`  date NOT NULL COMMENT '上课日期' ,
`lessonStartTime`  varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '上课开始时间' ,
`lessonEndTime`  varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '上课结束时间' ,
`createTime`  int(11) NOT NULL DEFAULT 0 COMMENT '创建时间' ,
`modifyTime`  int(11) NOT NULL COMMENT '编辑时间' ,
PRIMARY KEY (`id`)
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci
COMMENT='课表详情表'
AUTO_INCREMENT=31

;

-- ----------------------------
-- Table structure for `sky_SchooleInformation`
-- ----------------------------
DROP TABLE IF EXISTS `sky_SchooleInformation`;
CREATE TABLE `sky_SchooleInformation` (
`type`  varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '信息类型' ,
`text`  text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '信息' ,
`adminId`  int(11) NOT NULL DEFAULT 0 COMMENT '管理员ID' ,
`createTime`  int(11) NOT NULL COMMENT '创建时间' ,
`modifyTime`  int(11) NOT NULL COMMENT '编辑时间' ,
PRIMARY KEY (`type`)
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci
COMMENT='学院基本信息表'

;

-- ----------------------------
-- Table structure for `sky_Student`
-- ----------------------------
DROP TABLE IF EXISTS `sky_Student`;
CREATE TABLE `sky_Student` (
`id`  int(11) NOT NULL AUTO_INCREMENT COMMENT '主键' ,
`userId`  int(11) NOT NULL DEFAULT 0 COMMENT '用户ID' ,
`gradeClassId`  int(11) NOT NULL DEFAULT 0 COMMENT '班级Id' ,
`studyNum`  varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '000000000' COMMENT '学号' ,
`isBest`  tinyint(2) NOT NULL DEFAULT 0 COMMENT '是否是优秀学员' ,
`isDelete`  tinyint(2) NOT NULL DEFAULT 0 COMMENT '是否删除' ,
`createTime`  int(11) NOT NULL DEFAULT 0 COMMENT '添加时间' ,
`modifyTime`  int(11) NOT NULL DEFAULT 0 COMMENT '编辑时间' ,
PRIMARY KEY (`id`)
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci
COMMENT='学生表'
AUTO_INCREMENT=17

;

-- ----------------------------
-- Table structure for `sky_SysConfig`
-- ----------------------------
DROP TABLE IF EXISTS `sky_SysConfig`;
CREATE TABLE `sky_SysConfig` (
`id`  int(11) NOT NULL AUTO_INCREMENT COMMENT '主键' ,
PRIMARY KEY (`id`)
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci
COMMENT='网站系统配置表'
AUTO_INCREMENT=1

;

-- ----------------------------
-- Table structure for `sky_Tag`
-- ----------------------------
DROP TABLE IF EXISTS `sky_Tag`;
CREATE TABLE `sky_Tag` (
`id`  int(11) NOT NULL AUTO_INCREMENT COMMENT '主键' ,
`tagName`  varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '标签名' ,
`createTime`  int(11) NOT NULL DEFAULT 0 COMMENT '创建时间' ,
PRIMARY KEY (`id`)
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci
COMMENT='文章标签表'
AUTO_INCREMENT=18

;

-- ----------------------------
-- Table structure for `sky_Teacher`
-- ----------------------------
DROP TABLE IF EXISTS `sky_Teacher`;
CREATE TABLE `sky_Teacher` (
`id`  int(11) NOT NULL AUTO_INCREMENT COMMENT '主键' ,
`trueName`  varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '教师名称' ,
`sex`  tinyint(2) NOT NULL DEFAULT 1 COMMENT '教师性别（1男2女）' ,
`positionalTitles`  varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '职称' ,
`phone`  char(11) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '教师手机号' ,
`duties`  varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '行政职务' ,
`from`  varchar(150) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '来源情况' ,
`teachTopics`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '授课专题' ,
`studyField`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '研究领域' ,
`isDelete`  tinyint(2) NULL DEFAULT 0 COMMENT '是否删除（0否1是）' ,
`createTime`  int(11) NOT NULL DEFAULT 0 COMMENT '创建时间' ,
`modifyTime`  int(11) NOT NULL DEFAULT 0 COMMENT '编辑时间' ,
PRIMARY KEY (`id`)
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci
COMMENT='教师表'
AUTO_INCREMENT=9

;

-- ----------------------------
-- Table structure for `sky_TeachPlace`
-- ----------------------------
DROP TABLE IF EXISTS `sky_TeachPlace`;
CREATE TABLE `sky_TeachPlace` (
`id`  int(11) NOT NULL AUTO_INCREMENT COMMENT '主键' ,
`text`  varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '教学地点' ,
`address`  varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '具体地址' ,
`createTime`  int(11) NOT NULL DEFAULT 0 COMMENT '创建时间' ,
`modifyTime`  int(11) NOT NULL DEFAULT 0 COMMENT '编辑时间' ,
`isDelete`  tinyint(2) NOT NULL DEFAULT 0 COMMENT '是否删除' ,
`createAdminId`  int(11) NOT NULL DEFAULT 0 COMMENT '创建人ID' ,
`contacts`  varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '联系人' ,
`phone`  char(11) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '联系手机' ,
`website`  varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '网址' ,
`equipRemarks`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '设备情况备注' ,
`remarks`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '其他备注' ,
PRIMARY KEY (`id`)
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci
COMMENT='教学地点表'
AUTO_INCREMENT=15

;

-- ----------------------------
-- Table structure for `sky_TestPaper`
-- ----------------------------
DROP TABLE IF EXISTS `sky_TestPaper`;
CREATE TABLE `sky_TestPaper` (
`id`  int(11) NOT NULL AUTO_INCREMENT COMMENT '主键' ,
`title`  varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '试卷主题名' ,
`radioCount`  tinyint(4) NOT NULL DEFAULT 0 COMMENT '单选题数' ,
`multiCount`  tinyint(4) NOT NULL COMMENT '多选题数' ,
`t_fCount`  tinyint(4) NULL DEFAULT NULL COMMENT '判断题数' ,
`otherCount`  tinyint(4) NULL DEFAULT 0 COMMENT '其他题型数' ,
`questionCount`  tinyint(4) NOT NULL DEFAULT 0 COMMENT '试题数' ,
`isPublish`  tinyint(2) NOT NULL DEFAULT 0 COMMENT '发布状态(0未发布1已发布）' ,
`publishCode`  varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '发布时间类型' ,
`publishTime`  int(11) NULL DEFAULT 0 COMMENT '发布时间' ,
`verify`  tinyint(2) NOT NULL DEFAULT 1 COMMENT '是否审核（0未审核1已审核3审核失败）' ,
`verifyReason`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '审核理由' ,
`marks`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '备注' ,
`createTime`  int(11) NOT NULL COMMENT '创建时间' ,
`modifyTime`  int(11) NOT NULL COMMENT '编辑时间' ,
`createUserId`  int(11) NOT NULL DEFAULT 0 COMMENT '创建人ID' ,
`createUser`  varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '创建人账号' ,
`isDelete`  tinyint(2) NOT NULL DEFAULT 0 COMMENT '是否删除' ,
`gradeClassId`  int(11) NOT NULL DEFAULT 0 COMMENT '所属班级ID' ,
`timeToAnswer`  int(10) NOT NULL DEFAULT 0 COMMENT '作答时间（单位分钟）' ,
`from`  varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '试卷来源（由那个部门或处室）' ,
PRIMARY KEY (`id`)
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci
COMMENT='试卷表'
AUTO_INCREMENT=19

;

-- ----------------------------
-- Table structure for `sky_TestPaperQuestion`
-- ----------------------------
DROP TABLE IF EXISTS `sky_TestPaperQuestion`;
CREATE TABLE `sky_TestPaperQuestion` (
`paperId`  int(11) NOT NULL COMMENT '试卷ID' ,
`questId`  int(11) NOT NULL COMMENT '试题ID' ,
`score`  tinyint(4) NOT NULL COMMENT '分数' ,
`sorts`  tinyint(4) NOT NULL COMMENT '排序' ,
UNIQUE INDEX `ids_paperId_questId` (`paperId`, `questId`) USING BTREE 
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci

;

-- ----------------------------
-- Table structure for `sky_TestPaperQuestionRecord`
-- ----------------------------
DROP TABLE IF EXISTS `sky_TestPaperQuestionRecord`;
CREATE TABLE `sky_TestPaperQuestionRecord` (
`id`  int(11) NOT NULL AUTO_INCREMENT COMMENT '主键' ,
`anwserMark`  varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '答题标识（同一试卷同一批次答题标识一致；重复答题标识不一致）' ,
`userId`  int(11) NOT NULL COMMENT '用户ID' ,
`paperId`  int(11) NOT NULL COMMENT '试卷ID' ,
`questId`  int(11) NOT NULL COMMENT '试题ID' ,
`isRight`  tinyint(2) NOT NULL DEFAULT 0 COMMENT '是否正确（0否1是）' ,
`userAnswer`  int(5) NOT NULL DEFAULT 0 COMMENT '用户答案' ,
`userAnswerOpt`  varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '用户答案选项' ,
PRIMARY KEY (`id`)
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci
COMMENT='用户测评试卷试题答题记录表'
AUTO_INCREMENT=39

;

-- ----------------------------
-- Table structure for `sky_TestPaperUserStatistics`
-- ----------------------------
DROP TABLE IF EXISTS `sky_TestPaperUserStatistics`;
CREATE TABLE `sky_TestPaperUserStatistics` (
`id`  int(11) NOT NULL AUTO_INCREMENT COMMENT '主键' ,
`userId`  int(11) NOT NULL COMMENT '用户ID' ,
`account`  varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '用户账号' ,
`paperId`  int(11) NOT NULL COMMENT '试卷ID' ,
`anwserMark`  varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '答题标识(来源于sky_TestPaperQuestionRecord表）' ,
`scores`  tinyint(4) NOT NULL DEFAULT 0 COMMENT '总成绩' ,
`rightCount`  tinyint(4) NOT NULL COMMENT '正确数' ,
`rightScores`  tinyint(4) NOT NULL COMMENT '正确分数' ,
`wrongCount`  tinyint(4) NOT NULL COMMENT '错误数量' ,
`wrongScores`  tinyint(4) NOT NULL COMMENT '错误分数' ,
`answerTime`  int(10) NOT NULL DEFAULT 0 COMMENT '答题所花时间（单位秒）' ,
`createTime`  int(11) NOT NULL COMMENT '答题时间' ,
`modifyTime`  int(11) NOT NULL COMMENT '编辑时间' ,
PRIMARY KEY (`id`)
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci
COMMENT='用户试卷测评数据记录表'
AUTO_INCREMENT=11

;

-- ----------------------------
-- Table structure for `sky_User`
-- ----------------------------
DROP TABLE IF EXISTS `sky_User`;
CREATE TABLE `sky_User` (
`id`  int(11) NOT NULL AUTO_INCREMENT COMMENT '主键' ,
`account`  varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '用户名' ,
`userPwd`  varchar(150) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '用户密码' ,
`phone`  char(11) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '手机号' ,
`email`  varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '邮箱' ,
`roleId`  tinyint(4) NOT NULL DEFAULT 1 COMMENT '角色ID' ,
`loginIp`  char(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0' COMMENT '登录IP' ,
`lastLoginIp`  char(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0' COMMENT '上次登录Ip' ,
`loginCount`  int(10) NOT NULL DEFAULT 0 COMMENT '登录次数(默认为0)' ,
`isFrozen`  tinyint(2) NOT NULL DEFAULT 0 COMMENT '是否冻结（0否1是，默认为0）' ,
`isDelete`  tinyint(2) NOT NULL DEFAULT 0 COMMENT '是否删除' ,
`createTime`  int(11) NOT NULL COMMENT '创建时间（时间戳）' ,
`modifyTime`  int(11) NOT NULL COMMENT '编辑时间（时间戳）' ,
PRIMARY KEY (`id`),
INDEX `ids_isDelete` (`isDelete`) USING BTREE ,
INDEX `ids_roleId` (`roleId`) USING BTREE ,
INDEX `ids_account_userpwd` (`account`, `userPwd`) USING BTREE 
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci
COMMENT='用户表'
AUTO_INCREMENT=48

;

-- ----------------------------
-- Table structure for `sky_Video`
-- ----------------------------
DROP TABLE IF EXISTS `sky_Video`;
CREATE TABLE `sky_Video` (
`id`  int(11) NOT NULL AUTO_INCREMENT COMMENT '主键' ,
`video`  varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '视频' ,
`videoType`  tinyint(2) NOT NULL DEFAULT 1 COMMENT '视频类型（1本地视频2远程视频链接）' ,
`videoImg`  varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '视频背景图' ,
`descr`  varchar(150) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '视频描述' ,
`categoryId`  int(10) NOT NULL COMMENT '视频分类' ,
`provider`  varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '提供者' ,
`leader`  varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '院领导' ,
`remarks`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '备注' ,
`isDelete`  tinyint(2) NOT NULL DEFAULT 0 COMMENT '是否删除' ,
`sorts`  int(10) NOT NULL DEFAULT 100000 COMMENT '排序（值越小越靠前）' ,
`createTime`  int(11) NOT NULL DEFAULT 0 COMMENT '创建时间' ,
`modifyTime`  int(11) NOT NULL COMMENT '编辑时间' ,
`readCount`  int(11) NULL DEFAULT 0 COMMENT '预览量' ,
PRIMARY KEY (`id`),
INDEX `ids_isDelete_categoryId` (`isDelete`, `categoryId`) USING BTREE 
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci
COMMENT='视讯社园表'
AUTO_INCREMENT=32

;

-- ----------------------------
-- Table structure for `sky_Vote`
-- ----------------------------
DROP TABLE IF EXISTS `sky_Vote`;
CREATE TABLE `sky_Vote` (
`id`  int(11) NOT NULL AUTO_INCREMENT COMMENT '主键' ,
`subject`  varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '投票主题' ,
`subjectImg`  varchar(150) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '投票主题（图片链接地址）' ,
`selectType`  enum('radio','multi') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'radio' COMMENT '选择类型（ radio 单选 mulit 多选；默认 radio）' ,
`selectCount`  tinyint(4) NOT NULL DEFAULT 1 COMMENT '可选数（默认为1；为多选时，不能大于选项总数）' ,
`voteCounts`  int(11) NOT NULL DEFAULT 0 COMMENT '总票数' ,
`isClose`  tinyint(2) NOT NULL DEFAULT 0 COMMENT '是否关闭（0否1是；默认0）' ,
`isDelete`  tinyint(2) NOT NULL DEFAULT 0 COMMENT '是否删除（0否1是；默认0）' ,
`createUserId`  int(11) NOT NULL DEFAULT 0 COMMENT '创建人ID（默认0表示系统管理员）' ,
`createTime`  int(10) NOT NULL DEFAULT 0 COMMENT '创建时间' ,
`modifyTime`  int(10) NOT NULL DEFAULT 0 COMMENT '编辑时间' ,
PRIMARY KEY (`id`),
INDEX `ids_startDate_endDate_isClose_isDelete` (`isClose`, `isDelete`) USING BTREE 
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci
COMMENT='投票表'
AUTO_INCREMENT=18

;

-- ----------------------------
-- Table structure for `sky_VoteOptions`
-- ----------------------------
DROP TABLE IF EXISTS `sky_VoteOptions`;
CREATE TABLE `sky_VoteOptions` (
`id`  int(11) NOT NULL AUTO_INCREMENT COMMENT '主键' ,
`text`  varchar(150) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '选项值' ,
`voteId`  int(11) NOT NULL DEFAULT 0 COMMENT '投票ID' ,
`counts`  int(10) NOT NULL DEFAULT 0 COMMENT '投票数' ,
`sorts`  tinyint(4) NOT NULL COMMENT '排序' ,
`createTime`  int(10) NOT NULL DEFAULT 0 COMMENT '创建时间' ,
`modifyTime`  int(10) NOT NULL DEFAULT 0 COMMENT '编辑时间' ,
PRIMARY KEY (`id`)
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci
COMMENT='投票选项表'
AUTO_INCREMENT=37

;

-- ----------------------------
-- Table structure for `sky_VoteUser`
-- ----------------------------
DROP TABLE IF EXISTS `sky_VoteUser`;
CREATE TABLE `sky_VoteUser` (
`id`  int(11) NOT NULL AUTO_INCREMENT COMMENT '主键' ,
`naireId`  int(11) NOT NULL COMMENT '调查试卷ID' ,
`voteId`  int(11) NOT NULL DEFAULT 0 COMMENT '投票ID' ,
`userId`  int(11) NOT NULL DEFAULT 0 COMMENT '用户ID' ,
`optionsId`  int(11) NOT NULL DEFAULT 0 COMMENT '选项ID' ,
`createTime`  int(10) NOT NULL DEFAULT 0 COMMENT '创建时间' ,
PRIMARY KEY (`id`),
INDEX `ids_voteId_userId_optionsId` (`userId`, `voteId`, `optionsId`) USING BTREE 
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci
COMMENT='投票用户表'
AUTO_INCREMENT=43

;

-- ----------------------------
-- Table structure for `sky_WebCfg`
-- ----------------------------
DROP TABLE IF EXISTS `sky_WebCfg`;
CREATE TABLE `sky_WebCfg` (
`name`  varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '配置名称' ,
`value`  varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '配置值' ,
PRIMARY KEY (`name`)
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci
COMMENT='网站基础配置表'

;
-- ----------------------------
-- Records of sky_WebCfg
-- ----------------------------
INSERT INTO `sky_WebCfg` VALUES ('address', '成都市金牛区盛达街12号    联系电话：60182559');
INSERT INTO `sky_WebCfg` VALUES ('closeReasons', '');
INSERT INTO `sky_WebCfg` VALUES ('copyRight', '四川省社会主义学院');
INSERT INTO `sky_WebCfg` VALUES ('description', '');
INSERT INTO `sky_WebCfg` VALUES ('indexBottomBg', '');
INSERT INTO `sky_WebCfg` VALUES ('indexBottomSign', '');
INSERT INTO `sky_WebCfg` VALUES ('indexMainBanner1', 'http://18upload.oss-cn-hangzhou.aliyuncs.com/upload/index/829036720582797675.jpeg');
INSERT INTO `sky_WebCfg` VALUES ('indexMainBanner1Link', 'http://scnews.newssc.org/system/topic/6356/index.shtml');
INSERT INTO `sky_WebCfg` VALUES ('indexMainBanner2', 'http://18upload.oss-cn-hangzhou.aliyuncs.com/upload/index/300912965557572425.jpeg');
INSERT INTO `sky_WebCfg` VALUES ('indexMainBanner2Link', 'http://scnews.newssc.org/system/topic/4592/index.shtml');
INSERT INTO `sky_WebCfg` VALUES ('indexMainBanner3', '');
INSERT INTO `sky_WebCfg` VALUES ('indexMainBanner3Link', '');
INSERT INTO `sky_WebCfg` VALUES ('indexTopBg', '');
INSERT INTO `sky_WebCfg` VALUES ('keywords', '四川省社会主义学院官方网站');
INSERT INTO `sky_WebCfg` VALUES ('logo', 'http://18upload.oss-cn-hangzhou.aliyuncs.com/upload/image/2018-08-19/19369537382118417.png');
INSERT INTO `sky_WebCfg` VALUES ('postCodes', '610031');
INSERT INTO `sky_WebCfg` VALUES ('recordNumber', '蜀ICP备1097224号');
INSERT INTO `sky_WebCfg` VALUES ('siteName', '四川省社会主义学院网站');
INSERT INTO `sky_WebCfg` VALUES ('siteName2', '四川省中华文化学院');
INSERT INTO `sky_WebCfg` VALUES ('siteTitle', '四川省社会主义学院');
INSERT INTO `sky_WebCfg` VALUES ('status', '1');
INSERT INTO `sky_WebCfg` VALUES ('technicalSupport', '成都趣胤');
INSERT INTO `sky_WebCfg` VALUES ('watermarkCate', 'text');
INSERT INTO `sky_WebCfg` VALUES ('watermarkContent', '调试');
INSERT INTO `sky_WebCfg` VALUES ('watermarkPosition', '5');
INSERT INTO `sky_WebCfg` VALUES ('watermarkTextColor', 'dddddd');
INSERT INTO `sky_WebCfg` VALUES ('watermarkTextFont', '20');
