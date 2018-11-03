-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- 主机： localhost
-- 生成日期： 2018-11-03 12:36:33
-- 服务器版本： 10.2.18-MariaDB
-- PHP 版本： 7.2.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 数据库： `cxuucms`
--

-- --------------------------------------------------------

--
-- 表的结构 `cxuu_admin`
--

CREATE TABLE `cxuu_admin` (
  `user_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(50) NOT NULL,
  `nicename` varchar(11) NOT NULL,
  `email` varchar(20) NOT NULL,
  `stauts` int(2) NOT NULL,
  `level` int(5) DEFAULT NULL,
  `reg_time` int(10) DEFAULT NULL,
  `last_login_time` int(11) DEFAULT NULL,
  `last_login_ip` varchar(15) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `cxuu_admin`
--

INSERT INTO `cxuu_admin` (`user_id`, `group_id`, `username`, `password`, `nicename`, `email`, `stauts`, `level`, `reg_time`, `last_login_time`, `last_login_ip`) VALUES
(1, 1, 'cbkhwx', 'e77d78e3d7e2c581440dc451aff5b165', '邓中华', '13889991111', 1, 0, 0, 1541130506, '127.0.0.1'),
(2, 1, 'shannan', '0659c7992e268962384eb17fafe88364', '山南公安总帐号', 'aa@aa.aa', 1, 0, 0, 1539567696, '89.30.0.3'),
(3, 3, 'admin2', '96e79218965eb72c92a549dd5a330112', '汪琴', 'aa@aa.com', 1, NULL, NULL, 1540820316, '127.0.0.1'),
(4, 5, 'test1', '96e79218965eb72c92a549dd5a330112', '张三', '11@qq.com', 1, NULL, NULL, 1539451963, '89.10.19.30');

-- --------------------------------------------------------

--
-- 表的结构 `cxuu_admin_group`
--

CREATE TABLE `cxuu_admin_group` (
  `group_id` int(10) NOT NULL,
  `groupname` varchar(20) DEFAULT NULL,
  `base_purview` text DEFAULT NULL,
  `channel_purview` text DEFAULT NULL,
  `status` tinyint(1) DEFAULT 1
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='后台管理组';

--
-- 转存表中的数据 `cxuu_admin_group`
--

INSERT INTO `cxuu_admin_group` (`group_id`, `groupname`, `base_purview`, `channel_purview`, `status`) VALUES
(1, '超级管理员', 'a:11:{i:0;s:11:\"Index_index\";i:1;s:18:\"Settingcontr_index\";i:2;s:20:\"Adminusercontr_index\";i:3;s:21:\"Admingroupcontr_index\";i:4;s:18:\"Channelcontr_index\";i:5;s:18:\"Contentcontr_index\";i:6;s:21:\"Admingroupcontr_index\";i:7;s:23:\"Admingroupcontr_addedit\";i:8;s:24:\"Admingroupcontr_baseAuth\";i:9;s:19:\"Admingroupcontr_del\";i:10;s:20:\"Admingroupcontr_auth\";}', 'a:1:{i:0;s:1:\"1\";}', 1),
(2, '管理员', 'a:9:{i:0;s:11:\"index_index\";i:1;s:14:\"index_leftmenu\";i:2;s:10:\"index_home\";i:3;s:16:\"Menu_contentMenu\";i:4;s:22:\"Channelcontr_getJsTree\";i:5;s:18:\"Contentcontr_index\";i:6;s:20:\"Contentcontr_addedit\";i:7;s:22:\"Contentcontr_addAction\";i:8;s:23:\"Contentcontr_editAction\";}', 'a:4:{i:0;s:1:\"1\";i:1;s:1:\"4\";i:2;s:1:\"2\";i:3;s:1:\"3\";}', 1),
(3, '局办公室', 'a:14:{i:0;s:11:\"index_index\";i:1;s:14:\"index_leftmenu\";i:2;s:10:\"index_home\";i:3;s:16:\"Menu_contentMenu\";i:4;s:24:\"Upload_uploadWebuploader\";i:5;s:23:\"Upload_uploadSummernote\";i:6;s:17:\"Adminusercontr_pw\";i:7;s:21:\"Adminusercontr_pwedit\";i:8;s:18:\"Contentcontr_index\";i:9;s:22:\"Channelcontr_getJsTree\";i:10;s:20:\"Contentcontr_addedit\";i:11;s:22:\"Contentcontr_addAction\";i:12;s:23:\"Contentcontr_editAction\";i:13;s:20:\"Contentcontr_Publish\";}', 'a:6:{i:0;s:1:\"1\";i:1;s:1:\"4\";i:2;s:1:\"5\";i:3;s:1:\"2\";i:4;s:1:\"3\";i:5;s:1:\"7\";}', 1),
(4, '局政治部', 'a:2:{i:0;s:17:\"Adminusercontr_pw\";i:1;s:21:\"Adminusercontr_pwedit\";}', 'a:1:{i:0;s:1:\"3\";}', 1),
(5, '隆子县公安局', 'a:13:{i:0;s:11:\"index_index\";i:1;s:14:\"index_leftmenu\";i:2;s:10:\"index_home\";i:3;s:16:\"Menu_contentMenu\";i:4;s:23:\"Upload_uploadSummernote\";i:5;s:17:\"Adminusercontr_pw\";i:6;s:21:\"Adminusercontr_pwedit\";i:7;s:18:\"Contentcontr_index\";i:8;s:22:\"Channelcontr_getJsTree\";i:9;s:20:\"Contentcontr_addedit\";i:10;s:22:\"Contentcontr_addAction\";i:11;s:23:\"Contentcontr_editAction\";i:12;s:20:\"Contentcontr_Publish\";}', 'a:3:{i:0;s:1:\"1\";i:1;s:2:\"11\";i:2;s:2:\"13\";}', 1),
(6, '乃东区公安局', NULL, NULL, 1),
(7, '桑日县公安局', NULL, NULL, 1),
(8, '浪卡子县公安局', NULL, NULL, 1),
(9, '110指挥中心', NULL, NULL, 1),
(10, '科信支队', NULL, NULL, 1),
(11, '管理员测试', NULL, NULL, 0);

-- --------------------------------------------------------

--
-- 表的结构 `cxuu_admin_log`
--

CREATE TABLE `cxuu_admin_log` (
  `log_id` int(10) NOT NULL,
  `username` varchar(10) DEFAULT NULL,
  `time` int(10) DEFAULT NULL,
  `ip` varchar(250) DEFAULT NULL,
  `app` varchar(250) DEFAULT '1',
  `content` text DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='后台操作记录';

--
-- 转存表中的数据 `cxuu_admin_log`
--

INSERT INTO `cxuu_admin_log` (`log_id`, `username`, `time`, `ip`, `app`, `content`) VALUES
(1, 'cbkhwx', 1541130507, '127.0.0.1', '/Admin/Login/loginAction', '登录操作');

-- --------------------------------------------------------

--
-- 表的结构 `cxuu_attachments`
--

CREATE TABLE `cxuu_attachments` (
  `id` int(50) NOT NULL COMMENT '附件ID',
  `filename` varchar(250) NOT NULL,
  `fileurl` varchar(255) NOT NULL,
  `controller` varchar(250) NOT NULL,
  `updatetime` varchar(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='网站配置';

-- --------------------------------------------------------

--
-- 表的结构 `cxuu_channel`
--

CREATE TABLE `cxuu_channel` (
  `id` int(11) NOT NULL,
  `pid` int(11) NOT NULL,
  `urlname` varchar(20) NOT NULL,
  `attribute` tinyint(2) NOT NULL,
  `name` varchar(11) NOT NULL,
  `keywords` varchar(200) NOT NULL COMMENT '栏目关键字',
  `description` varchar(200) NOT NULL COMMENT '栏目描述',
  `DisplayNum` int(10) NOT NULL DEFAULT 20 COMMENT '显示数量',
  `Template` text NOT NULL COMMENT '栏目模板',
  `sort` int(10) NOT NULL COMMENT '排序'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `cxuu_channel`
--

INSERT INTO `cxuu_channel` (`id`, `pid`, `urlname`, `attribute`, `name`, `keywords`, `description`, `DisplayNum`, `Template`, `sort`) VALUES
(1, 0, '', 0, '山南警讯', '', '', 20, 'list', 1),
(2, 0, '', 0, '山南公安', '', '心里所想', 20, 'list', 1),
(3, 2, 'science', 1, '重要文件', '', '', 20, 'list', 1),
(4, 1, '', 1, '公安要闻', '', '', 20, 'list', 1),
(5, 1, '', 1, '通知通报', '', '1234', 20, 'list', 3),
(7, 2, '', 1, '政策法规', '', '', 20, '', 5),
(8, 2, '', 1, '媒体聚焦', '', '', 20, 'list', 4),
(11, 1, '', 1, '县区动态', '', '', 20, 'list', 3),
(9, 1, '', 1, '每日动态', '', '', 20, 'list', 6),
(19, 0, '', 1, '局长专栏', '', '', 20, 'list', 0),
(18, 0, '', 1, '书记专栏', '', '', 20, 'list', 0),
(10, 2, '', 1, '队伍建设', '', '', 20, 'list', 0),
(12, 1, '', 1, '部门动态', '', '', 20, 'list', 2),
(13, 1, '', 1, '一线警务', '', '', 20, 'list', 4),
(14, 2, '', 1, '党建工作', '', '', 20, 'list', 0),
(15, 2, '', 1, '纪检监察', '', '', 20, 'list', 0),
(16, 2, '', 1, '警务督察', '', '', 20, 'list', 0),
(17, 2, '', 1, '教育训练', '', '', 20, 'list', 0);

-- --------------------------------------------------------

--
-- 表的结构 `cxuu_comment`
--

CREATE TABLE `cxuu_comment` (
  `id` int(50) NOT NULL,
  `aid` int(50) NOT NULL COMMENT '内容ID',
  `content` text NOT NULL COMMENT '评论内容',
  `status` int(2) DEFAULT NULL COMMENT '评论状态'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `cxuu_comment`
--

INSERT INTO `cxuu_comment` (`id`, `aid`, `content`, `status`) VALUES
(0, 0, '<p>\r\n				龙啸轩测试档龙啸轩测试档龙啸轩测试档龙啸轩测试档龙啸轩测试档龙啸轩测试档龙啸轩测试档龙啸轩测试档			</p>', 0);

-- --------------------------------------------------------

--
-- 表的结构 `cxuu_content`
--

CREATE TABLE `cxuu_content` (
  `id` int(20) NOT NULL,
  `cid` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `position_a` tinyint(1) DEFAULT NULL COMMENT '头条',
  `position_b` tinyint(1) DEFAULT NULL COMMENT '小头条',
  `position_c` tinyint(1) DEFAULT NULL COMMENT '轮换',
  `image` varchar(200) DEFAULT '0' COMMENT '缩略图',
  `imageBL` tinyint(1) NOT NULL DEFAULT 0 COMMENT '有无图片',
  `auther` varchar(11) DEFAULT '''NULL''' COMMENT '拟稿人',
  `examine` varchar(20) DEFAULT NULL COMMENT '审核人',
  `publish` varchar(20) DEFAULT NULL COMMENT '发布人',
  `usergroupname` varchar(20) DEFAULT NULL COMMENT '用户组名',
  `auditstate` varchar(50) DEFAULT NULL COMMENT '审核说明',
  `description` varchar(500) DEFAULT 'NULL' COMMENT '描述',
  `created_date` int(11) DEFAULT NULL,
  `edited_date` int(11) DEFAULT NULL,
  `user_id` int(5) DEFAULT NULL,
  `hits` int(50) DEFAULT 1,
  `status` tinyint(1) DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `cxuu_content`
--

INSERT INTO `cxuu_content` (`id`, `cid`, `title`, `position_a`, `position_b`, `position_c`, `image`, `imageBL`, `auther`, `examine`, `publish`, `usergroupname`, `auditstate`, `description`, `created_date`, `edited_date`, `user_id`, `hits`, `status`) VALUES
(1, 18, 'ddddddddddddddddddddd', NULL, 1, NULL, '', 0, '龙啸轩', '邓中华', '邓中华', '超级管理员', '', '', 1541084458, NULL, 1, 2, 1);

-- --------------------------------------------------------

--
-- 表的结构 `cxuu_content_content`
--

CREATE TABLE `cxuu_content_content` (
  `id` int(50) NOT NULL,
  `aid` int(50) NOT NULL COMMENT '文章ID',
  `content` mediumtext DEFAULT NULL COMMENT '内容'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `cxuu_content_content`
--

INSERT INTO `cxuu_content_content` (`id`, `aid`, `content`) VALUES
(1, 1, '&lt;p&gt;11&lt;/p&gt;');

-- --------------------------------------------------------

--
-- 表的结构 `cxuu_juleader`
--

CREATE TABLE `cxuu_juleader` (
  `id` int(50) NOT NULL,
  `name` varchar(50) NOT NULL COMMENT '姓名',
  `image` varchar(200) DEFAULT NULL COMMENT '照片',
  `duty` varchar(200) DEFAULT NULL COMMENT '职务',
  `division` varchar(200) DEFAULT NULL COMMENT '分管工作',
  `phone` varchar(20) DEFAULT NULL COMMENT '电话',
  `sort` int(10) NOT NULL DEFAULT 1 COMMENT '排序',
  `status` int(2) NOT NULL DEFAULT 1 COMMENT '状态'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='领导信息';

--
-- 转存表中的数据 `cxuu_juleader`
--

INSERT INTO `cxuu_juleader` (`id`, `name`, `image`, `duty`, `division`, `phone`, `sort`, `status`) VALUES
(2, '扎西次仁', '/uploads/image/20181009/63782dc1df5d552a4673d173e567cdd6.jpg', '副局长', '交警支队', '13889009375', 2, 1),
(3, '阿萨', '/uploads/image/20181009/63782dc1df5d552a4673d173e567cdd6.jpg', '副局长', '1111111111', '13889009375', 1, 1),
(4, '测试', '/uploads/image/20181014/7e403d22882e8b911816cf0c96a4fcbe.jpg', '公安局局长、督察长', '指挥中心', '', 3, 1);

-- --------------------------------------------------------

--
-- 表的结构 `cxuu_jumail`
--

CREATE TABLE `cxuu_jumail` (
  `id` int(50) NOT NULL,
  `uid` int(50) DEFAULT NULL COMMENT '收件人ID',
  `category` varchar(20) DEFAULT NULL COMMENT '分类',
  `title` varchar(50) DEFAULT NULL COMMENT '标题',
  `writename` varchar(20) DEFAULT NULL COMMENT '写信人',
  `department` varchar(50) DEFAULT NULL COMMENT '部门',
  `phone` varchar(15) DEFAULT NULL COMMENT '电话',
  `addr` varchar(100) DEFAULT NULL COMMENT '地址',
  `content` text DEFAULT NULL COMMENT '信件内容',
  `reply` text DEFAULT NULL COMMENT '回复',
  `ip` varchar(20) DEFAULT NULL,
  `status` int(2) DEFAULT NULL,
  `greatttime` varchar(50) DEFAULT NULL COMMENT '写信时间',
  `replytime` varchar(50) DEFAULT NULL COMMENT '回复时间'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `cxuu_jumail`
--

INSERT INTO `cxuu_jumail` (`id`, `uid`, `category`, `title`, `writename`, `department`, `phone`, `addr`, `content`, `reply`, `ip`, `status`, `greatttime`, `replytime`) VALUES
(1, 2, '投诉', '测试测试', '测试', '测试', '13889009375', '测试', '测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试', '&lt;span style=&quot;font-weight: 700;&quot;&gt;&lt;i style=&quot;color: rgb(255, 0, 0);&quot;&gt;&lt;span style=&quot;font-family: 微软雅黑; font-size: 36px;&quot;&gt;测试测&lt;/span&gt;&lt;/i&gt;&lt;/span&gt;&lt;br&gt;', NULL, 1, NULL, '1539077614'),
(2, 2, '', '', '', '', '', '', '', NULL, '89.10.19.30', NULL, '1539143300', NULL),
(3, 2, '建议', '', '', '', '', '', '', NULL, '89.10.19.30', NULL, '1539143542', NULL),
(4, 2, '建议', '', '', '', '', '', '', NULL, '89.10.19.30', NULL, '1539143617', NULL),
(5, 2, '建议', '前端测试', '前端测试', '前端测试', '13889009375', '前端测试', '前端测试前端测试前端测试前端测试前端测试前端测试前端测试前端测试前端测试前端测试前端测试前端测试', '&lt;p&gt;&amp;nbsp;&lt;/p&gt;', '89.10.19.30', 0, '1539144277', '1539447537'),
(6, 3, '建议', '前端测试', '1111', '11', '13889009375', '前端测试', '1243214', '&lt;p&gt;&lt;span style=&quot;color: rgb(255, 156, 0);&quot;&gt;工村曼框图韩国框图国栽&lt;/span&gt;&lt;/p&gt;', '89.10.19.30', 1, '1539144824', '1539144862'),
(7, 2, '建议', '涨工资的请示', '陈希', '指挥中心', '13889009375', '指挥中心', '9月17日上午，市公安局组织相关部门前往白日街口参加“9.16平安山南宣传日”集中宣传活动。市委常委、政法委书记、市公安局党委书记龚兵亲临现场指导参观宣传活动，市公安局党委委员、副局长杨世斌陪同。龚兵同志强调一要强化政治攻势，大力宣传“扫黑除恶 打非治乱”专项斗争工作；二要充分利用板报、标语等形式广泛宣传，发动所有人积极参与行动；三要警钟长鸣，加大摸排力度。', '&lt;p&gt;好的建议可以执行！！&lt;/p&gt;', '89.10.19.30', 1, '1539446477', '1539446787'),
(8, 2, '建议', '涨工资的请示', '陈希', '前端测试', '13889009375', '指挥中心', '9月17日上午，市公安局组织相关部门前往白日街口参加“9.16平安山南宣传日”集中宣传活动。市委常委、政法委书记、市公安局党委书记龚兵亲临现场指导参观宣传活动，市公安局党委委员、副局长杨世斌陪同。龚兵同志强调一要强化政治攻势，大力宣传“扫黑除恶 打非治乱”专项斗争工作；二要充分利用板报、标语等形式广泛宣传，发动所有人积极参与行动；三要警钟长鸣，加大摸排力度。', NULL, '89.10.19.30', NULL, '1539446595', NULL),
(9, 3, '建议', '11', '111', '111', '11', '11', '1111', NULL, '127.0.0.1', NULL, '1540537578', NULL);

-- --------------------------------------------------------

--
-- 表的结构 `cxuu_notice`
--

CREATE TABLE `cxuu_notice` (
  `id` int(100) NOT NULL COMMENT 'ID',
  `did` int(100) NOT NULL COMMENT '判断位置调用ID',
  `title` varchar(100) DEFAULT NULL,
  `content` text DEFAULT NULL COMMENT '内容',
  `publisher` varchar(20) DEFAULT NULL COMMENT '发布人',
  `created_date` int(20) DEFAULT NULL,
  `status` tinyint(2) DEFAULT NULL COMMENT '是否显示'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='内容点击数量';

--
-- 转存表中的数据 `cxuu_notice`
--

INSERT INTO `cxuu_notice` (`id`, `did`, `title`, `content`, `publisher`, `created_date`, `status`) VALUES
(1, 2, 'ddddddddddddddddddddd', '122', '', NULL, 1),
(2, 2, '2341241412', '&lt;span style=&quot;color: rgb(255, 0, 0);&quot;&gt;调用 value=1 前台 value=2 后台&lt;/span&gt;', '22', NULL, 1),
(3, 2, '测试公告', '&lt;p&gt;测试公告&lt;br&gt;&lt;/p&gt;', '测试', 1540703769, 1);

-- --------------------------------------------------------

--
-- 表的结构 `cxuu_onduty`
--

CREATE TABLE `cxuu_onduty` (
  `id` int(50) NOT NULL COMMENT 'ID',
  `dutycat` varchar(100) DEFAULT NULL COMMENT '值班类别',
  `name` varchar(50) DEFAULT NULL COMMENT '姓名',
  `duty` varchar(100) DEFAULT NULL COMMENT '职务',
  `callsign` varchar(10) DEFAULT NULL COMMENT '手台呼号',
  `phone` varchar(20) DEFAULT NULL COMMENT '联系电话',
  `note` varchar(200) DEFAULT NULL COMMENT '备注',
  `sort` int(2) DEFAULT NULL COMMENT '排序',
  `status` int(2) DEFAULT NULL COMMENT '是否显示'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='值班安排表';

--
-- 转存表中的数据 `cxuu_onduty`
--

INSERT INTO `cxuu_onduty` (`id`, `dutycat`, `name`, `duty`, `callsign`, `phone`, `note`, `sort`, `status`) VALUES
(1, '1', '张山李四', '局办公室主任', '100321', '13889009375', '前往浪卡子县检查工作', 1, 0),
(2, '2', '李明李明', '党委书记、政法委书记', '200321', '13889009375', '正在休假', 2, 0),
(3, '2', '洛桑次仁', '公安局局长、督察长', '200321', '13889009375', '前往浪卡子县检查工作', 0, 1);

-- --------------------------------------------------------

--
-- 表的结构 `cxuu_settings`
--

CREATE TABLE `cxuu_settings` (
  `name` varchar(50) NOT NULL,
  `info` varchar(10000) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `cxuu_settings`
--

INSERT INTO `cxuu_settings` (`name`, `info`) VALUES
('sitesetting', 'a:11:{s:10:\"site_title\";s:27:\"龙啸轩信息管理系统\";s:13:\"site_subtitle\";s:24:\"简单、易用、轻巧\";s:8:\"site_url\";s:18:\"http://89.30.70.9/\";s:13:\"site_keywords\";s:27:\"龙啸轩信息管理系统\";s:16:\"site_description\";s:82:\" 电话：0891-6666666 版权所有 Copyright (c) 龙啸轩信息管理系统 2018\";s:10:\"site_email\";s:14:\"admin@cxuu.net\";s:14:\"site_copyright\";s:27:\"龙啸轩信息管理系统\";s:15:\"site_statistics\";s:9:\"123412412\";s:6:\"submit\";s:0:\"\";s:15:\"site_copyright2\";s:7:\"sssssss\";s:11:\"upload_size\";s:3:\"900\";}'),
('uploadsetting', '');

-- --------------------------------------------------------

--
-- 表的结构 `cxuu_user`
--

CREATE TABLE `cxuu_user` (
  `id` int(10) NOT NULL,
  `name` varchar(50) NOT NULL,
  `power` varchar(100) NOT NULL,
  `info` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `cxuu_user`
--

INSERT INTO `cxuu_user` (`id`, `name`, `power`, `info`) VALUES
(1, '邓中华', '超级管理员', '我是一个非常爱学习的人！'),
(2, '邓琪耀', '管理员', '22222我是一个非常爱学习的人！');

--
-- 转储表的索引
--

--
-- 表的索引 `cxuu_admin`
--
ALTER TABLE `cxuu_admin`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `id` (`user_id`);

--
-- 表的索引 `cxuu_admin_group`
--
ALTER TABLE `cxuu_admin_group`
  ADD PRIMARY KEY (`group_id`),
  ADD KEY `name` (`groupname`);

--
-- 表的索引 `cxuu_admin_log`
--
ALTER TABLE `cxuu_admin_log`
  ADD PRIMARY KEY (`log_id`),
  ADD KEY `user_id` (`username`) USING BTREE;

--
-- 表的索引 `cxuu_attachments`
--
ALTER TABLE `cxuu_attachments`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `cxuu_channel`
--
ALTER TABLE `cxuu_channel`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `cxuu_comment`
--
ALTER TABLE `cxuu_comment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `aid` (`aid`);

--
-- 表的索引 `cxuu_content`
--
ALTER TABLE `cxuu_content`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cid` (`cid`),
  ADD KEY `status` (`status`) USING BTREE,
  ADD KEY `position_a` (`position_a`),
  ADD KEY `position_b` (`position_b`),
  ADD KEY `position_c` (`position_c`),
  ADD KEY `imageBL` (`imageBL`);

--
-- 表的索引 `cxuu_content_content`
--
ALTER TABLE `cxuu_content_content`
  ADD PRIMARY KEY (`id`),
  ADD KEY `aid` (`aid`);

--
-- 表的索引 `cxuu_juleader`
--
ALTER TABLE `cxuu_juleader`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `cxuu_jumail`
--
ALTER TABLE `cxuu_jumail`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `cxuu_notice`
--
ALTER TABLE `cxuu_notice`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `cxuu_onduty`
--
ALTER TABLE `cxuu_onduty`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `cxuu_settings`
--
ALTER TABLE `cxuu_settings`
  ADD PRIMARY KEY (`name`);

--
-- 表的索引 `cxuu_user`
--
ALTER TABLE `cxuu_user`
  ADD PRIMARY KEY (`id`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `cxuu_admin`
--
ALTER TABLE `cxuu_admin`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- 使用表AUTO_INCREMENT `cxuu_admin_group`
--
ALTER TABLE `cxuu_admin_group`
  MODIFY `group_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- 使用表AUTO_INCREMENT `cxuu_admin_log`
--
ALTER TABLE `cxuu_admin_log`
  MODIFY `log_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- 使用表AUTO_INCREMENT `cxuu_attachments`
--
ALTER TABLE `cxuu_attachments`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT COMMENT '附件ID';

--
-- 使用表AUTO_INCREMENT `cxuu_channel`
--
ALTER TABLE `cxuu_channel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- 使用表AUTO_INCREMENT `cxuu_content`
--
ALTER TABLE `cxuu_content`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- 使用表AUTO_INCREMENT `cxuu_content_content`
--
ALTER TABLE `cxuu_content_content`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- 使用表AUTO_INCREMENT `cxuu_juleader`
--
ALTER TABLE `cxuu_juleader`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- 使用表AUTO_INCREMENT `cxuu_jumail`
--
ALTER TABLE `cxuu_jumail`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- 使用表AUTO_INCREMENT `cxuu_notice`
--
ALTER TABLE `cxuu_notice`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT COMMENT 'ID', AUTO_INCREMENT=4;

--
-- 使用表AUTO_INCREMENT `cxuu_onduty`
--
ALTER TABLE `cxuu_onduty`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT COMMENT 'ID', AUTO_INCREMENT=4;

--
-- 使用表AUTO_INCREMENT `cxuu_user`
--
ALTER TABLE `cxuu_user`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
