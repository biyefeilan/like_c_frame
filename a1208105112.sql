-- phpMyAdmin SQL Dump
-- version 2.7.0-pl1
-- http://www.phpmyadmin.net
-- 
-- 主机: localhost
-- 生成日期: 2013 年 09 月 28 日 03:01
-- 服务器版本: 5.0.96
-- PHP 版本: 5.2.17
-- 
-- 数据库: `a1208105112`
-- 

-- --------------------------------------------------------

-- 
-- 表的结构 `co_manager`
-- 

CREATE TABLE `co_manager` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `site_name` varchar(100) NOT NULL,
  `site_url` varchar(255) NOT NULL,
  `site_logo` varchar(255) NOT NULL,
  `collector` varchar(100) NOT NULL,
  `interval_time` int(10) unsigned NOT NULL default '0',
  `collect_time` int(10) unsigned NOT NULL default '0',
  `collecting` tinyint(1) unsigned NOT NULL default '0',
  `collect_maxtime` int(10) unsigned NOT NULL default '0',
  `model` varchar(50) NOT NULL,
  `status` tinyint(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=gbk AUTO_INCREMENT=5 ;

-- 
-- 导出表中的数据 `co_manager`
-- 

INSERT INTO `co_manager` VALUES (1, '不正常人类-人人小站', 'http://zhan.renren.com/fengzimen/', '', 'Fengzimen', 7200, 1380330523, 0, 3600, 'mo_funny', 0);
INSERT INTO `co_manager` VALUES (2, '电影首发', 'http://www.xzshoufa.com/', '', 'Xzshoufa', 86400, 1380258719, 0, 7200, 'mo_bt', 0);
INSERT INTO `co_manager` VALUES (3, '笑话-淘网址', 'http://xiaohua.tao123.com', '', 'Tao123', 3600, 1357657008, 0, 3800, 'mo_funny_image', 1);
INSERT INTO `co_manager` VALUES (4, '经典美文网', 'http://meiwen.ishuo.cn/', '', 'Ishuo', 21600, 1363069846, 0, 21600, 'mo_meiwen', 1);

-- --------------------------------------------------------

-- 
-- 表的结构 `co_reporter`
-- 

CREATE TABLE `co_reporter` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `Co_Manager_id` int(10) unsigned NOT NULL,
  `collector` varchar(50) NOT NULL,
  `start` datetime NOT NULL,
  `end` datetime NOT NULL,
  `total` int(10) unsigned NOT NULL default '0',
  `save` int(10) unsigned NOT NULL default '0',
  `message` text NOT NULL,
  `result` varchar(50) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3051 DEFAULT CHARSET=gbk;

-- --------------------------------------------------------

-- 
-- 表的结构 `e_in_a_word`
-- 

CREATE TABLE `e_in_a_word` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `word` text NOT NULL,
  `author` varchar(50) NOT NULL,
  `source` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk AUTO_INCREMENT=1 ;

-- 
-- 导出表中的数据 `e_in_a_word`
-- 


-- --------------------------------------------------------

-- 
-- 表的结构 `e_tags`
-- 

CREATE TABLE `e_tags` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `tag` varchar(30) NOT NULL,
  `ref` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk AUTO_INCREMENT=1 ;

-- 
-- 导出表中的数据 `e_tags`
-- 


-- --------------------------------------------------------

-- 
-- 表的结构 `mo_bt`
-- 

CREATE TABLE `mo_bt` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `unique_id` varchar(100) NOT NULL,
  `Co_Manager_id` int(10) unsigned NOT NULL,
  `collect_time` int(10) unsigned NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `bt` mediumtext NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `unique_id` (`unique_id`)
) ENGINE=MyISAM AUTO_INCREMENT=893 DEFAULT CHARSET=gbk;