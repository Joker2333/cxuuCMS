-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- 主机： localhost
-- 生成日期： 2018-12-23 11:27:23
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
(1, 1, 'cbkhwx', 'e77d78e3d7e2c581440dc451aff5b165', '邓中华', '18989010903', 1, 0, 0, 1545535366, '127.0.0.1');

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
(1, '超级管理员', 'a:17:{i:0;s:16:\"Menu_channelMenu\";i:1;s:18:\"Settingcontr_index\";i:2;s:20:\"Adminusercontr_index\";i:3;s:24:\"Adminusercontr_addaction\";i:4;s:18:\"Adminusercontr_del\";i:5;s:21:\"Admingroupcontr_index\";i:6;s:23:\"Admingroupcontr_addedit\";i:7;s:24:\"Admingroupcontr_baseAuth\";i:8;s:30:\"Admingroupcontr_baseAuthAction\";i:9;s:19:\"Admingroupcontr_del\";i:10;s:18:\"Channelcontr_index\";i:11;s:20:\"Channelcontr_addEdit\";i:12;s:22:\"Channelcontr_addAction\";i:13;s:23:\"Channelcontr_editAction\";i:14;s:19:\"Channelcontr_Delete\";i:15;s:18:\"Contentcontr_index\";i:16;s:19:\"Contentcontr_Delete\";}', NULL, 1),
(2, '审核员', 'a:13:{i:0;s:11:\"index_index\";i:1;s:14:\"index_leftmenu\";i:2;s:10:\"index_home\";i:3;s:16:\"Menu_contentMenu\";i:4;s:18:\"Contentcontr_index\";i:5;s:22:\"Channelcontr_getJsTree\";i:6;s:20:\"Contentcontr_addedit\";i:7;s:22:\"Contentcontr_addAction\";i:8;s:23:\"Contentcontr_editAction\";i:9;s:15:\"Content_examine\";i:10;s:20:\"Documentscontr_index\";i:11;s:22:\"Documentscontr_addEdit\";i:12;s:24:\"Documentscontr_addAction\";}', 'a:5:{i:0;s:1:\"1\";i:1;s:1:\"5\";i:2;s:1:\"2\";i:3;s:1:\"4\";i:4;s:1:\"3\";}', 1);

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
(5, 1, '', 1, '通知通报', '', '1234', 20, '', 3),
(7, 2, '', 1, '政策法规', '', '', 20, 'list', 5),
(8, 2, '', 1, '媒体聚焦', '', '', 20, 'list', 4),
(11, 1, '', 1, '县区动态', '', '', 20, 'list', 3),
(9, 1, '', 1, '每日动态', '', '', 20, 'list', 6),
(19, 0, '', 1, '局长专栏', '', '', 20, 'list', 0),
(18, 0, '', 1, '书记专栏', '', '', 20, 'list', 0),
(10, 2, '', 1, '队伍建设', '', '', 20, 'list', 0),
(12, 1, '', 1, '部门动态', '', '', 20, 'list', 2),
(13, 1, '', 1, '警情快讯', '', '', 20, 'list', 4),
(14, 2, '', 1, '党建工作', '', '', 20, 'list', 0),
(15, 2, '', 1, '纪检监察', '', '', 20, 'list', 0),
(16, 2, '', 1, '警务督察', '', '', 20, 'list', 0),
(17, 2, '', 1, '教育训练', '', '', 20, 'list', 0),
(20, 2, '', 1, '保密工作', '', '', 20, 'list', 0);

-- --------------------------------------------------------

--
-- 表的结构 `cxuu_content`
--

CREATE TABLE `cxuu_content` (
  `id` int(20) NOT NULL,
  `cid` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `position_a` tinyint(1) DEFAULT NULL,
  `position_b` tinyint(1) DEFAULT NULL,
  `position_c` tinyint(1) DEFAULT NULL,
  `image` varchar(200) DEFAULT NULL,
  `imageBL` tinyint(1) NOT NULL DEFAULT 0 COMMENT '有无图片',
  `examine` varchar(50) DEFAULT NULL COMMENT '审核人',
  `publish` varchar(50) DEFAULT NULL COMMENT '发布人',
  `auther` varchar(11) DEFAULT NULL COMMENT '拟稿人',
  `usergroupname` varchar(50) DEFAULT NULL COMMENT '用户组名',
  `auditstate` varchar(50) DEFAULT NULL COMMENT '审核说明',
  `description` varchar(500) DEFAULT NULL COMMENT '描述',
  `created_date` int(11) DEFAULT NULL,
  `edited_date` int(11) DEFAULT NULL,
  `user_id` int(5) NOT NULL,
  `hits` int(11) NOT NULL DEFAULT 1,
  `status` tinyint(1) DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `cxuu_content_content`
--

CREATE TABLE `cxuu_content_content` (
  `aid` int(20) NOT NULL COMMENT '文章ID',
  `content` mediumtext DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `cxuu_documents`
--

CREATE TABLE `cxuu_documents` (
  `id` int(20) NOT NULL,
  `cid` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `docnumber` varchar(100) DEFAULT NULL COMMENT '文号',
  `public` tinyint(1) NOT NULL DEFAULT 1 COMMENT '是否公开',
  `examine` varchar(50) DEFAULT 'NULL' COMMENT '签发人',
  `image` varchar(200) DEFAULT NULL,
  `imageBL` tinyint(1) NOT NULL DEFAULT 0 COMMENT '有无图片',
  `publish` varchar(50) DEFAULT NULL COMMENT '发布人',
  `auther` varchar(11) DEFAULT NULL COMMENT '拟稿人',
  `usergroupname` varchar(50) DEFAULT NULL COMMENT '用户组名',
  `auditstate` varchar(50) DEFAULT NULL COMMENT '审核说明',
  `created_date` int(11) DEFAULT NULL,
  `edited_date` int(11) DEFAULT NULL,
  `user_id` int(5) NOT NULL,
  `hits` int(11) NOT NULL DEFAULT 1,
  `status` tinyint(1) DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `cxuu_documents_content`
--

CREATE TABLE `cxuu_documents_content` (
  `aid` int(20) NOT NULL COMMENT '文章ID',
  `content` mediumtext DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `cxuu_documents_signin`
--

CREATE TABLE `cxuu_documents_signin` (
  `id` int(50) NOT NULL COMMENT 'ID',
  `aid` int(50) NOT NULL COMMENT '文件ID',
  `signinname` varchar(10) NOT NULL COMMENT '签收人名字',
  `group_id` int(5) NOT NULL COMMENT '签收组ID',
  `groupname` varchar(10) NOT NULL COMMENT '签收人单位',
  `ip` varchar(20) NOT NULL COMMENT '签收人IP',
  `time` int(20) NOT NULL COMMENT '签收时间',
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '状态'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

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

-- --------------------------------------------------------

--
-- 表的结构 `cxuu_notice`
--

CREATE TABLE `cxuu_notice` (
  `id` int(100) NOT NULL,
  `did` int(100) NOT NULL COMMENT '前后判断',
  `title` varchar(100) DEFAULT NULL COMMENT '标题',
  `content` text DEFAULT NULL COMMENT '内容',
  `publisher` varchar(20) DEFAULT NULL COMMENT '发布人',
  `created_date` int(20) DEFAULT NULL COMMENT '创建时间',
  `status` tinyint(1) DEFAULT NULL COMMENT '是否显示'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='前后台公告';

--
-- 转存表中的数据 `cxuu_notice`
--

INSERT INTO `cxuu_notice` (`id`, `did`, `title`, `content`, `publisher`, `created_date`, `status`) VALUES
(1, 2, '上传图片模式', '&lt;p&gt;&lt;span style=&quot;color: rgb(255, 0, 0); font-size: 18px;&quot;&gt;上传图片前高宽请控制在1100像素以内&lt;/span&gt;&lt;/p&gt;', '邓中华', 1541232648, 1),
(2, 2, '系统更新', '&lt;p&gt;1.对一些主要功能进行了重写，合程序运行效率更高。更新了最新THINKPHP框架到 5.28 LTS。&lt;/p&gt;&lt;p&gt;2.对数据库结构进行调整，使查询效率更高！提高了3倍查询速度，30万条大数据测试可在0.1秒以内完成。&lt;/p&gt;&lt;p&gt;3.前端新增 Redis 内存缓存技术，并分段式逻辑算法，全页面数据缓存，让用户感受不到任何延迟；&lt;/p&gt;&lt;p&gt;4.对前期发现的一些BUG进行了更正。&lt;/p&gt;&lt;p&gt;5.优化了一些功能，更符合使用习惯。&lt;/p&gt;', '邓中华', 1541234725, 1),
(3, 2, '前端有缓存', '&lt;p&gt;&lt;span style=&quot;color: rgb(255, 0, 0);&quot;&gt;在后台发布的内容在前台要一小段时间才会刷新出来，因为缓存机制！&lt;/span&gt;&lt;/p&gt;', '邓中华', 1542679401, 1),
(4, 2, '优化了一些功能', '&lt;p&gt;&lt;span style=&quot;color: rgb(255, 0, 255);&quot;&gt;优化了一些功能&lt;/span&gt;&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;color: rgb(255, 0, 255);&quot;&gt;更新thinkphp&amp;nbsp;框架&amp;nbsp;到5.1.29LTS&lt;br&gt;&lt;/span&gt;&lt;br&gt;&lt;/p&gt;', '邓中华', 1543311298, 1);

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

-- --------------------------------------------------------

--
-- 表的结构 `cxuu_onlinemusic`
--

CREATE TABLE `cxuu_onlinemusic` (
  `id` int(20) NOT NULL,
  `cid` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `docnumber` varchar(100) DEFAULT NULL COMMENT '简介',
  `examine` varchar(50) DEFAULT 'NULL' COMMENT '音乐来源',
  `image` varchar(200) DEFAULT NULL,
  `imageBL` tinyint(1) NOT NULL DEFAULT 0 COMMENT '有无图片',
  `publish` varchar(50) DEFAULT NULL COMMENT '发布人',
  `auther` varchar(11) DEFAULT NULL COMMENT '艺术家',
  `usergroupname` varchar(50) DEFAULT NULL COMMENT '用户组名',
  `musicurl` varchar(200) DEFAULT NULL COMMENT '音乐地址',
  `created_date` int(11) DEFAULT NULL,
  `edited_date` int(11) DEFAULT NULL,
  `user_id` int(5) NOT NULL,
  `hits` int(11) NOT NULL DEFAULT 1,
  `status` tinyint(1) DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

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
('sitesetting', 'a:13:{s:10:\"site_title\";s:27:\"拉萨公安监管信息网\";s:13:\"site_subtitle\";s:24:\"简单、易用、轻巧\";s:8:\"site_url\";s:18:\"http://89.30.70.9/\";s:13:\"site_keywords\";s:27:\"拉萨公安监管信息网\";s:16:\"site_description\";s:77:\" 电话：0891-22 版权所有 Copyright (c) 拉萨公安监管信息网 2018\";s:10:\"site_email\";s:17:\"admin@cxuucms.com\";s:14:\"site_copyright\";s:27:\"拉萨公安监管信息网\";s:15:\"site_statistics\";s:9:\"123412412\";s:6:\"submit\";s:0:\"\";s:15:\"site_copyright2\";s:7:\"sssssss\";s:11:\"upload_size\";s:3:\"900\";s:17:\"upload_meida_size\";s:4:\"8000\";s:17:\"upload_media_size\";s:4:\"8100\";}'),
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
  ADD PRIMARY KEY (`user_id`);

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
-- 表的索引 `cxuu_content`
--
ALTER TABLE `cxuu_content`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cid` (`cid`),
  ADD KEY `status` (`status`),
  ADD KEY `position_a` (`position_a`),
  ADD KEY `position_b` (`position_b`),
  ADD KEY `position_c` (`position_c`),
  ADD KEY `imageBL` (`imageBL`);

--
-- 表的索引 `cxuu_content_content`
--
ALTER TABLE `cxuu_content_content`
  ADD PRIMARY KEY (`aid`),
  ADD KEY `aid` (`aid`);

--
-- 表的索引 `cxuu_documents`
--
ALTER TABLE `cxuu_documents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cid` (`cid`),
  ADD KEY `status` (`status`),
  ADD KEY `imageBL` (`imageBL`);

--
-- 表的索引 `cxuu_documents_content`
--
ALTER TABLE `cxuu_documents_content`
  ADD PRIMARY KEY (`aid`);

--
-- 表的索引 `cxuu_documents_signin`
--
ALTER TABLE `cxuu_documents_signin`
  ADD PRIMARY KEY (`id`);

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
-- 表的索引 `cxuu_onlinemusic`
--
ALTER TABLE `cxuu_onlinemusic`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cid` (`cid`),
  ADD KEY `status` (`status`),
  ADD KEY `imageBL` (`imageBL`);

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
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- 使用表AUTO_INCREMENT `cxuu_admin_group`
--
ALTER TABLE `cxuu_admin_group`
  MODIFY `group_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- 使用表AUTO_INCREMENT `cxuu_admin_log`
--
ALTER TABLE `cxuu_admin_log`
  MODIFY `log_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `cxuu_attachments`
--
ALTER TABLE `cxuu_attachments`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT COMMENT '附件ID';

--
-- 使用表AUTO_INCREMENT `cxuu_channel`
--
ALTER TABLE `cxuu_channel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- 使用表AUTO_INCREMENT `cxuu_content`
--
ALTER TABLE `cxuu_content`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `cxuu_documents`
--
ALTER TABLE `cxuu_documents`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `cxuu_documents_signin`
--
ALTER TABLE `cxuu_documents_signin`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT COMMENT 'ID';

--
-- 使用表AUTO_INCREMENT `cxuu_juleader`
--
ALTER TABLE `cxuu_juleader`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `cxuu_jumail`
--
ALTER TABLE `cxuu_jumail`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `cxuu_notice`
--
ALTER TABLE `cxuu_notice`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- 使用表AUTO_INCREMENT `cxuu_onduty`
--
ALTER TABLE `cxuu_onduty`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT COMMENT 'ID';

--
-- 使用表AUTO_INCREMENT `cxuu_onlinemusic`
--
ALTER TABLE `cxuu_onlinemusic`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `cxuu_user`
--
ALTER TABLE `cxuu_user`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
