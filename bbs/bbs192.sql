-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 2017-09-27 16:25:40
-- 服务器版本： 10.1.13-MariaDB
-- PHP Version: 7.0.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bbs192`
--

-- --------------------------------------------------------

--
-- 表的结构 `config`
--

CREATE TABLE `config` (
  `id` int(11) NOT NULL,
  `webname` varchar(255) NOT NULL,
  `keywords` varchar(255) NOT NULL,
  `logo` varchar(255) NOT NULL,
  `copy` varchar(255) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `config`
--

INSERT INTO `config` (`id`, `webname`, `keywords`, `logo`, `copy`, `status`) VALUES
(1, 'MyBBS', 'PHP,JAVA,Python，C#', 'th_20170924071442_196.jpg', '渝ICP备10000000', 1);

-- --------------------------------------------------------

--
-- 表的结构 `friendlink`
--

CREATE TABLE `friendlink` (
  `id` int(11) NOT NULL,
  `linkname` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `content` text NOT NULL,
  `ordernum` tinyint(4) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `friendlink`
--

INSERT INTO `friendlink` (`id`, `linkname`, `url`, `logo`, `content`, `ordernum`, `status`) VALUES
(1, '百度', 'http://www.baidu.com', 'th_20170907042339_155.jpg', '百度', 1, 1),
(2, '淘宝', 'http://www.taobao.com', 'th_20170907044256_420.jpg', '淘宝', 2, 1),
(4, '京东', 'http://www.jd.com', 'th_20170907160807_966.jpg', '京东商城', 3, 1),
(5, '当当', 'http:://www.dangdang.com', 'th_20170908080735_779.png', '当当购物网', 4, 1);

-- --------------------------------------------------------

--
-- 表的结构 `history`
--

CREATE TABLE `history` (
  `id` int(10) NOT NULL,
  `uid` int(10) NOT NULL,
  `type` tinyint(1) NOT NULL,
  `ctime` int(11) NOT NULL,
  `target_id` int(10) DEFAULT NULL,
  `content` varchar(255) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- 转存表中的数据 `history`
--

INSERT INTO `history` (`id`, `uid`, `type`, `ctime`, `target_id`, `content`) VALUES
(3, 4, 1, 1504711510, NULL, NULL),
(4, 4, 1, 1504711548, NULL, NULL),
(5, 26, 2, 1504711744, NULL, NULL),
(6, 26, 1, 1504711938, NULL, NULL),
(7, 26, 3, 1504712086, NULL, NULL),
(8, 26, 1, 1504712290, NULL, NULL),
(9, 26, 3, 1504712875, 64, '呵呵呵诶收到发号施令的风景'),
(10, 26, 4, 1504712934, 64, '自己顶！！！！！'),
(11, 26, 4, 1504713017, 64, '的风格大方个的发个'),
(12, 26, 4, 1504713057, 64, '啦啦啦'),
(13, 26, 4, 1504713191, 64, '很符合法规'),
(14, 26, 4, 1504713217, 62, '哈哈'),
(15, 4, 1, 1504757217, NULL, NULL),
(16, 4, 3, 1504761513, 65, 'sdfsdf'),
(17, 4, 3, 1504761975, 66, '斯蒂芬斯蒂芬收到'),
(18, 4, 1, 1504769643, NULL, NULL),
(19, 4, 1, 1504773651, NULL, NULL),
(20, 4, 3, 1504774428, 67, '哈哈哈哈哈哈哈哈啊哈哈哈哈哈'),
(21, 4, 4, 1504775300, 57, '13211313'),
(22, 28, 2, 1504781747, NULL, NULL),
(23, 28, 1, 1504781753, NULL, NULL),
(24, 28, 3, 1504781783, 68, '在线视频课程下载'),
(25, 28, 4, 1504781797, 68, '自己顶！！！！！！！！！！！！！'),
(26, 28, 3, 1504782092, 69, '阿里云 - 为了无法计算的价值'),
(27, 28, 4, 1504783508, 18, '呀呀呀'),
(28, 28, 1, 1504783670, NULL, NULL),
(29, 28, 4, 1504783691, 64, '哈哈哈哈哈哈'),
(30, 4, 1, 1504790996, NULL, NULL),
(31, 4, 1, 1504792969, NULL, NULL),
(32, 4, 4, 1504792983, 20, '顶一下'),
(33, 4, 1, 1504836382, NULL, NULL),
(34, 4, 4, 1504841860, 66, '啦啦啦啦啦啦'),
(35, 4, 4, 1504842022, 66, '哈哈哈哈哈'),
(36, 4, 4, 1504844299, 57, '哈哈哈哈'),
(37, 4, 3, 1504844928, 70, '测试啦啦啦啦'),
(38, 4, 3, 1504845227, 71, '啦啦啦啦'),
(39, 4, 1, 1504851391, NULL, NULL),
(40, 31, 2, 1504851793, NULL, NULL),
(41, 31, 1, 1504851804, NULL, NULL),
(42, 31, 1, 1504851853, NULL, NULL),
(43, 31, 1, 1504851912, NULL, NULL),
(44, 31, 3, 1504852119, 72, '测试测试'),
(45, 31, 3, 1504852144, 73, '测试测试2'),
(46, 31, 3, 1504852157, 74, '测试测试3'),
(47, 31, 4, 1504852386, 73, '萨达所大所'),
(48, 31, 1, 1504852415, NULL, NULL),
(49, 31, 4, 1504852432, 73, '测试测试'),
(50, 31, 4, 1504852437, 73, '测试'),
(51, 4, 1, 1504869197, NULL, NULL),
(52, 4, 1, 1506230344, NULL, NULL),
(53, 4, 1, 1506230983, NULL, NULL),
(54, 4, 1, 1506233814, NULL, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `post`
--

CREATE TABLE `post` (
  `id` int(10) UNSIGNED NOT NULL,
  `uid` int(11) NOT NULL,
  `tid` int(11) NOT NULL,
  `title` char(255) NOT NULL,
  `content` text NOT NULL,
  `ctime` int(11) NOT NULL,
  `count` int(11) DEFAULT '0',
  `elite` tinyint(4) DEFAULT '0',
  `top` tinyint(4) DEFAULT '0',
  `recycle` tinyint(4) DEFAULT '0',
  `reply` tinyint(1) DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `post`
--

INSERT INTO `post` (`id`, `uid`, `tid`, `title`, `content`, `ctime`, `count`, `elite`, `top`, `recycle`, `reply`) VALUES
(7, 4, 3, 'JAVA新手100个小例子练习', '这是内容这是内容这是内容这是内容这是内容这是内容这是内容', 1504670360, 27, 0, 0, 0, 1),
(72, 31, 128, '测试测试', '<p>测试<br/></p>', 1504852119, 3, 0, 0, 0, 1),
(73, 31, 128, '测试测试2', '<p>11<br/></p>', 1504852144, 9, 0, 0, 0, 1),
(9, 4, 2, '测试3测试3测试3测试3测试3', '这是内容这是内容这是内容这是内容这是内容这是内容这是内容', 1504670358, 0, 0, 0, 0, 1),
(10, 4, 2, '测试2测试2测试2测试2测试2', '这是内容这是内容这是内容这是内容这是内容这是内容这是内容', 1504670358, 0, 0, 0, 0, 1),
(11, 4, 2, '测试4测试4测试4测试4测试4', '这是内容这是内容这是内容这是内容这是内容这是内容这是内容', 1504670358, 0, 0, 0, 0, 1),
(12, 4, 2, '测试5测试5测试5测试5测试5', '这是内容这是内容这是内容这是内容这是内容这是内容这是内容', 1504670358, 0, 0, 0, 0, 1),
(14, 4, 2, '测试7测试7测试7测试7', '这是内容这是内容这是内容这是内容这是内容这是内容这是内容', 1504671804, 3, 0, 0, 0, 1),
(15, 4, 2, '测试8测试8测试8测试8', '这是内容这是内容这是内容这是内容这是内容这是内容这是内容', 1504671804, 30, 0, 0, 0, 1),
(16, 4, 2, '测试9测试9测试9测试9', '这是内容这是内容这是内容这是内容这是内容这是内容这是内容', 1504671804, 0, 0, 0, 0, 1),
(18, 4, 2, '测试11测试11测试11测试11', '这是内容这是内容这是内容这是内容这是内容这是内容这是内容', 1504671804, 2, 0, 0, 0, 1),
(19, 4, 2, '测试12测试12测试12测试12', '这是内容这是内容这是内容这是内容这是内容这是内容这是内容', 1504671804, 1, 0, 0, 0, 1),
(20, 4, 2, '测试13测试13测试13测试13', '这是内容这是内容这是内容这是内容这是内容这是内容这是内容', 1504671804, 5, 0, 0, 0, 1),
(21, 4, 2, '测试14测试14测试14测试14', '这是内容这是内容这是内容这是内容这是内容这是内容这是内容', 1504671804, 0, 0, 0, 0, 1),
(22, 4, 2, '测试15测试15测试15测试15', '这是内容这是内容这是内容这是内容这是内容这是内容这是内容', 1504671804, 0, 0, 0, 0, 1),
(23, 4, 2, '测试16测试16测试16测试16', '这是内容这是内容这是内容这是内容这是内容这是内容这是内容', 1504671804, 0, 0, 0, 0, 1),
(24, 4, 2, '测试17测试17测试17测试17', '这是内容这是内容这是内容这是内容这是内容这是内容这是内容', 1504671804, 0, 0, 0, 0, 1),
(25, 4, 2, '测试18测试18测试18测试18', '这是内容这是内容这是内容这是内容这是内容这是内容这是内容', 1504671804, 0, 0, 0, 0, 1),
(26, 4, 2, '测试19测试19测试19测试19', '这是内容这是内容这是内容这是内容这是内容这是内容这是内容', 1504671804, 0, 0, 0, 0, 1),
(27, 4, 2, '测试20测试20测试20测试20', '这是内容这是内容这是内容这是内容这是内容这是内容这是内容', 1504671804, 0, 0, 0, 0, 1),
(28, 4, 2, '测试21测试21测试21测试21', '这是内容这是内容这是内容这是内容这是内容这是内容这是内容', 1504671804, 0, 0, 0, 0, 1),
(29, 4, 2, '测试22测试22测试22测试22', '这是内容这是内容这是内容这是内容这是内容这是内容这是内容', 1504671804, 0, 0, 0, 0, 1),
(30, 4, 2, '测试23测试23测试23测试23', '这是内容这是内容这是内容这是内容这是内容这是内容这是内容', 1504671804, 0, 0, 0, 0, 1),
(31, 4, 2, '测试24测试24测试24测试24', '这是内容这是内容这是内容这是内容这是内容这是内容这是内容', 1504671804, 0, 0, 0, 0, 1),
(32, 4, 2, '测试25测试25测试25测试25', '这是内容这是内容这是内容这是内容这是内容这是内容这是内容', 1504671804, 23, 0, 0, 0, 1),
(33, 4, 2, '测试26测试26测试26测试26', '这是内容这是内容这是内容这是内容这是内容这是内容这是内容', 1504671804, 0, 0, 0, 0, 1),
(34, 4, 2, '测试27测试27测试27测试27', '这是内容这是内容这是内容这是内容这是内容这是内容这是内容', 1504671804, 0, 0, 0, 0, 1),
(35, 4, 2, '测试28测试28测试28测试28', '这是内容这是内容这是内容这是内容这是内容这是内容这是内容', 1504671804, 0, 0, 0, 0, 1),
(36, 4, 2, '测试29测试29测试29测试29', '这是内容这是内容这是内容这是内容这是内容这是内容这是内容', 1504671804, 0, 0, 0, 0, 1),
(37, 4, 2, '测试30测试30测试30测试30', '这是内容这是内容这是内容这是内容这是内容这是内容这是内容', 1504671804, 0, 0, 0, 0, 1),
(38, 4, 2, '测试31测试31测试31测试31', '这是内容这是内容这是内容这是内容这是内容这是内容这是内容', 1504671804, 0, 0, 0, 0, 1),
(39, 4, 2, '测试32测试32测试32测试32', '这是内容这是内容这是内容这是内容这是内容这是内容这是内容', 1504671804, 0, 0, 0, 0, 1),
(40, 4, 2, '测试33测试33测试33测试33', '这是内容这是内容这是内容这是内容这是内容这是内容这是内容', 1504671804, 0, 0, 0, 0, 1),
(41, 4, 2, '测试34测试34测试34测试34', '这是内容这是内容这是内容这是内容这是内容这是内容这是内容', 1504671804, 0, 0, 0, 0, 1),
(42, 4, 2, '测试35测试35测试35测试35', '这是内容这是内容这是内容这是内容这是内容这是内容这是内容', 1504671804, 0, 0, 0, 0, 1),
(43, 4, 2, '测试36测试36测试36测试36', '这是内容这是内容这是内容这是内容这是内容这是内容这是内容', 1504671804, 0, 0, 0, 0, 1),
(44, 4, 2, '测试37测试37测试37测试37', '这是内容这是内容这是内容这是内容这是内容这是内容这是内容', 1504671804, 0, 0, 0, 0, 1),
(45, 4, 2, '测试38测试38测试38测试38', '这是内容这是内容这是内容这是内容这是内容这是内容这是内容', 1504671804, 0, 0, 0, 1, 1),
(70, 4, 2, '测试啦啦啦啦', '哈哈哈', 1504844928, 12, 0, 0, 0, 0),
(71, 4, 2, '啦啦啦啦', '<p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;死了开放你上课防守打法 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; 从VB从VB</p>', 1504845227, 6, 0, 0, 1, 1),
(47, 4, 2, '测试40测试40测试40测试40', '这是内容这是内容这是内容这是内容这是内容这是内容这是内容', 1504671804, 0, 0, 0, 1, 1),
(48, 4, 2, '测试41测试41测试41测试41', '这是内容这是内容这是内容这是内容这是内容这是内容这是内容', 1504671804, 0, 0, 0, 1, 1),
(68, 28, 9, '在线视频课程下载', '<p>在线视频课程下载</p>', 1504781783, 2, 0, 0, 1, 1),
(50, 4, 2, '测试43测试43测试43测试43', '这是内容这是内容这是内容这是内容这是内容这是内容这是内容', 1504671804, 0, 0, 0, 1, 1),
(51, 4, 2, '测试44测试44测试44测试44', '这是内容这是内容这是内容这是内容这是内容这是内容这是内容', 1504671804, 0, 0, 0, 0, 1),
(52, 4, 2, '测试45测试45测试45测试45', '这是内容这是内容这是内容这是内容这是内容这是内容这是内容', 1504671804, 0, 0, 0, 0, 1),
(66, 4, 2, '斯蒂芬斯蒂芬收到反反复复111', '<p>斯蒂芬斯蒂芬的风格大方个反反复复<br/></p>', 1504761975, 21, 0, 0, 0, 1),
(55, 4, 2, '测试48测试48测试48测试48', '这是内容这是内容这是内容这是内容这是内容这是内容这是内容', 1504671855, 3, 0, 0, 0, 1),
(56, 4, 2, '测试49测试49测试49测试49', '这是内容这是内容这是内容这是内容这是内容这是内容这是内容', 1504671804, 0, 0, 0, 0, 1),
(57, 4, 2, '测试50测试50测试50测试50', '这是内容这是内容这是内容这是内容这是内容这是内容这是内容', 1504671804, 111, 0, 1, 0, 1),
(58, 4, 2, '打工的个地方', '<p>电饭锅打工的发<br/></p>', 1504687540, 245, 0, 0, 1, 1),
(59, 4, 0, '哈哈哈哈哈哈哈哈', '呵呵呵呵呵呵呵', 1504688879, 1, 0, 0, 1, 1),
(60, 4, 2, '的风格大方个的规定发给对方', '<p><img src="http://localhost/bbs/Home/Public/umeditor/php/upload/20170906/15046903756668.jpg"/></p>', 1504690378, 2, 0, 0, 0, 1),
(63, 26, 3, '啦啦啦啦啦啦', '<p>啦啦啦啦啦啦<br/></p>', 1504712086, 8, 0, 0, 1, 1),
(64, 26, 4, '呵呵呵诶收到发号施令的风景', '<p>加速度发斯蒂芬<br/></p>', 1504712875, 15, 0, 0, 0, 1),
(67, 4, 2, '哈哈哈哈哈哈哈哈啊哈哈哈哈哈', '<p><br/></p><p>哈哈哈哈哈哈哈哈啊哈哈哈哈哈</p><p><br/></p><p>哈哈哈哈哈哈哈哈啊哈哈哈哈哈</p>', 1504774428, 23, 1, 0, 1, 0),
(69, 28, 2, '阿里云 - 为了无法计算的价值', '', 1504782092, 5, 0, 0, 0, 1),
(74, 31, 128, '测试测试3', '<p>111<br/></p>', 1504852157, 3, 1, 0, 0, 0);

-- --------------------------------------------------------

--
-- 表的结构 `reply`
--

CREATE TABLE `reply` (
  `id` int(10) UNSIGNED NOT NULL,
  `uid` int(11) NOT NULL,
  `pid` int(11) NOT NULL,
  `content` text NOT NULL,
  `ctime` int(11) NOT NULL,
  `position` int(10) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `reply`
--

INSERT INTO `reply` (`id`, `uid`, `pid`, `content`, `ctime`, `position`) VALUES
(13, 4, 58, '啦啦啦啦', 1504693041, 1),
(14, 4, 58, '法国恢复规划法规和', 1504693698, 2),
(15, 4, 58, '法国恢复规划法规和', 1504693801, 3),
(16, 4, 58, '哈哈哈哈哈哈', 1504694014, 4),
(17, 4, 58, '哈哈哈哈哈哈', 1504694062, 5),
(46, 31, 73, '测试', 1504852437, 3),
(19, 4, 58, '啦啦啦啦啦啦', 1504694570, 6),
(45, 31, 73, '测试测试', 1504852432, 2),
(22, 4, 58, 'sdgdfg', 1504694961, 9),
(44, 31, 73, '萨达所大所', 1504852386, 1),
(41, 4, 66, '啦啦啦啦啦啦', 1504841860, 1),
(26, 4, 58, 'sdfsdfsf', 1504707669, 12),
(40, 4, 20, '顶一下', 1504792983, 1),
(42, 4, 66, '哈哈哈哈哈', 1504842022, 2),
(43, 4, 57, '哈哈哈哈', 1504844299, 2),
(36, 4, 57, '13211313', 1504775300, 1);

-- --------------------------------------------------------

--
-- 表的结构 `type`
--

CREATE TABLE `type` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` char(20) NOT NULL,
  `status` tinyint(4) DEFAULT '1',
  `pid` int(11) NOT NULL DEFAULT '0',
  `path` char(255) NOT NULL DEFAULT '0',
  `blogo` varchar(255) NOT NULL DEFAULT 'default.jpg',
  `intro` varchar(255) DEFAULT '暂无介绍'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `type`
--

INSERT INTO `type` (`id`, `name`, `status`, `pid`, `path`, `blogo`, `intro`) VALUES
(1, '技术交流1', 1, 0, '0', 'default.jpg', NULL),
(2, 'PHP技术', 1, 1, '0-1', 'PHP.png', 'PHP基础编程、疑难解答、学习和开发过程中的经验总结等。'),
(3, 'Java/Android技术', 1, 1, '0-1', 'java.png', '本版块提供Java学习视频中遇到的各种学习问题，有私密问题也可以与威哥交流哦。'),
(4, '前端（HTML5）技术', 1, 1, '0-1', 'HTML5.png', '前台技术HTML、JavaScript、DIV、CSS、XML、Ajax等相关技术的学习及讨论。'),
(5, '服务器与Linux技术', 1, 1, '0-1', 'linux.png', 'Linux操作系统及Web服务相关新闻、技术交流、经验总结等。'),
(6, '全栈（OS/DB/PHP/WebAPP）', 1, 1, '0-1', 'sql.png', '全栈（OS/DB/PHP/WebAPP）'),
(7, 'UI/UE技术', 1, 1, '0-1', 'ui.jpg', 'UI/ UE设计技术交流-专注UI/UE基础入门视频教程，海量UI素材库，实时分享UI设计最新作品及文章。'),
(8, '兄弟连', 1, 0, '0', 'default.jpg', NULL),
(9, '视频教程/在线课', 1, 8, '0-8', '101.png', 'LAMP兄弟连打造免费视频教程，致力于做中国最好的视频教程。本版块发布PHP、MySQL等方面的视频教程。'),
(10, '培训课程', 1, 8, '0-8', '175.png', '兄弟连的IT人才培训计划，关注IT培训最新动态，了解课程精彩内容。全国统一咨询热线：400-700-1307'),
(11, '兄弟会', 1, 8, '0-8', '275.png', '兄弟会专注高端，NB技术大牛导师+公司创始人整合资源， 专培养全面复合型高端IT人才。'),
(12, '战地日记', 1, 8, '0-8', 'zhandirij.png', '职场如战场，战场需要军人，而职场需要的是职业人！战地日记是展现LAMP兄弟连新兵（学生、社会人）转变为合格军人（职业人）的心路历程，记录连队（学习）生活的点点滴滴，分享其中的收获与快乐！提升职业竞争力，塑造彪悍职业生涯！'),
(13, '兄弟连小电影', 1, 8, '0-8', '273.png', '兄弟连小电影，分享兄弟连师生各种奇闻异事。'),
(14, '明哥聊求职', 1, 8, '0-8', '285.png', '李明，长相安全，学历谦虚，没有背景，只有背影，混迹于职场十六七年，待过各式各样的公司，做过五花八门的工作，从打杂小职员到项目经理、技术总监，兄弟连教育联合创始人、副总裁。近年来致力于职业教育及为年轻人提供求职与职业素质指导，希望用自己的经历与经验，帮助到更多迷茫的求职者。'),
(15, '连队趣事', 1, 0, '0', 'linux.png', NULL),
(16, '招聘求职', 1, 15, '0-15', 'sql.png', '本版用于交流如何求职及如何更好在职场中发展。'),
(17, '吹水圣地', 1, 15, '0-15', 'th_20170907155219_352.png', '本版收录LAMP兄弟连最新活动信息、活动简报、奇闻趣谈等。'),
(18, '议事厅', 1, 0, '0-15', 'lampjianyi.png', '议事厅'),
(19, '兄弟连建议', 1, 18, '0-15', 'huiyi.png', 'LAMP兄弟连官方发布管理公告和最新信息的地方，假如兄弟有任何意见或建议也可以发布在此。'),
(20, '版主会议室', 1, 18, '0-15', 'th_20170907155339_395.png', '版主会议室'),
(114, '啦啦啦哈哈哈', 1, 1, '0-1', 'th_20170907154950_171.jpg', '暂无介绍'),
(115, '瞎扯蛋', 1, 8, '0-8', 'th_20170907155300_760.png', '暂无介绍'),
(127, '测试', 1, 0, '0', 'default.jpg', '暂无介绍'),
(128, '测试', 1, 127, '0-127', 'th_20170908082641_726.png', '暂无介绍');

-- --------------------------------------------------------

--
-- 表的结构 `user`
--

CREATE TABLE `user` (
  `id` int(10) UNSIGNED NOT NULL,
  `userName` char(20) NOT NULL,
  `password` char(33) NOT NULL,
  `auth` tinyint(4) NOT NULL DEFAULT '0',
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `lastlogin` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `user`
--

INSERT INTO `user` (`id`, `userName`, `password`, `auth`, `status`, `lastlogin`) VALUES
(22, '3333', '2be9bd7a3434f7038ca27d1918de58bd', 0, 1, 1504611494),
(4, 'pandaxnm', 'b59c67bf196a4758191e42f76670ceba', 2, 1, 1506233814),
(20, '1111', 'b59c67bf196a4758191e42f76670ceba', 0, 1, 1504611376),
(23, '5555', '6074c6aa3488f3c2dddff2a7ca821aab', 0, 1, 1504611543),
(25, '7777', 'e10adc3949ba59abbe56e057f20f883e', 0, 1, 1504612546),
(26, 'lalalla', '9aa6e5f2256c17d2d430b100032b997c', 0, 1, 1504712290),
(27, 'sdfsdf', '77963b7a931377ad4ab5ad6a9cd718aa', 0, 1, 1504769535),
(24, '6666', 'e9510081ac30ffa83f10b68cde1cac07', 0, 1, 1504612492),
(28, 'haha', '4e4d6c332b6fe62a63afe56171fd3725', 0, 1, 1504783670),
(30, 'lllllll', 'bf083d4ab960620b645557217dd59a49', 1, 1, 1504850189),
(31, '测试', '934b535800b1cba8f96a5d72f72f1611', 0, 1, 1504852415),
(32, '测试2', '934b535800b1cba8f96a5d72f72f1611', 0, 1, 1504851934);

-- --------------------------------------------------------

--
-- 表的结构 `userdetail`
--

CREATE TABLE `userdetail` (
  `id` int(10) UNSIGNED NOT NULL,
  `uid` int(10) UNSIGNED NOT NULL,
  `nickName` char(50) DEFAULT NULL,
  `email` char(50) DEFAULT NULL,
  `qq` char(15) DEFAULT NULL,
  `sex` enum('w','m') DEFAULT 'm',
  `photo` char(255) NOT NULL DEFAULT 'default.jpg',
  `score` int(10) NOT NULL DEFAULT '100'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `userdetail`
--

INSERT INTO `userdetail` (`id`, `uid`, `nickName`, `email`, `qq`, `sex`, `photo`, `score`) VALUES
(13, 20, 'vvvvvv', '11@qq.com', '', 'm', 'default.jpg', 100),
(4, 10, 'ada', '11', '11142', 'm', 'default.jpg', 0),
(5, 11, 'asda', '023xcj@gmail.com', '2342', 'm', 'default.jpg', 0),
(17, 24, 'sdfsf', '6666@qq.com', '23523', 'm', 'default.jpg', 100),
(10, 4, '熊大帅x', '1111@qq.com', '242', 'm', 'th_20170908081641_226.png', 314),
(11, 0, NULL, '', NULL, 'm', 'default.jpg', 100),
(12, 0, NULL, '', NULL, 'm', 'default.jpg', 100),
(15, 22, 'ssss', '3333@qq.com', '7525', 'm', 'default.jpg', 100),
(16, 23, NULL, '5555@qq.com', NULL, 'm', 'default.jpg', 100),
(18, 25, 'bb', '7777@qq.com', '235235', 'm', 'default.jpg', 100),
(19, 26, '我是lalala', 'lala@qq.com', '', 'm', 'default.jpg', 186),
(20, 27, NULL, 'ddd@qq.com', NULL, 'm', 'default.jpg', 100),
(21, 28, '啦啦啦', 'haha@qq.com', '', 'm', 'th_20170907125738_318.jpg', 156),
(23, 30, NULL, 'djkv@qq.com', NULL, 'm', 'default.jpg', 100),
(24, 31, '熊大帅', '9588@qq.com', '958884479', 'm', 'th_20170908082345_920.png', 176),
(25, 32, NULL, 'klfdjf@qq.com', NULL, 'm', 'default.jpg', 100);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `config`
--
ALTER TABLE `config`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `friendlink`
--
ALTER TABLE `friendlink`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `linkname` (`linkname`);

--
-- Indexes for table `history`
--
ALTER TABLE `history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reply`
--
ALTER TABLE `reply`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `type`
--
ALTER TABLE `type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `userName` (`userName`);

--
-- Indexes for table `userdetail`
--
ALTER TABLE `userdetail`
  ADD PRIMARY KEY (`id`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `config`
--
ALTER TABLE `config`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- 使用表AUTO_INCREMENT `friendlink`
--
ALTER TABLE `friendlink`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- 使用表AUTO_INCREMENT `history`
--
ALTER TABLE `history`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;
--
-- 使用表AUTO_INCREMENT `post`
--
ALTER TABLE `post`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;
--
-- 使用表AUTO_INCREMENT `reply`
--
ALTER TABLE `reply`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;
--
-- 使用表AUTO_INCREMENT `type`
--
ALTER TABLE `type`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=129;
--
-- 使用表AUTO_INCREMENT `user`
--
ALTER TABLE `user`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;
--
-- 使用表AUTO_INCREMENT `userdetail`
--
ALTER TABLE `userdetail`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
