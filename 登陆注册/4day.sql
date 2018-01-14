-- phpMyAdmin SQL Dump
-- version 3.4.10.1
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2015 年 09 月 02 日 04:44
-- 服务器版本: 5.5.20
-- PHP 版本: 5.3.10

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `jxshop`
--

-- --------------------------------------------------------

--
-- 表的结构 `jxshop_admin`
--

CREATE TABLE IF NOT EXISTS `jxshop_admin` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Id',
  `username` varchar(30) NOT NULL COMMENT '账号',
  `password` char(32) NOT NULL COMMENT '密码',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='管理员' AUTO_INCREMENT=4 ;

--
-- 转存表中的数据 `jxshop_admin`
--

INSERT INTO `jxshop_admin` (`id`, `username`, `password`) VALUES
(1, 'root', '21232f297a57a5a743894a0e4a801fc3'),
(3, 'abc', '900150983cd24fb0d6963f7d28e17f72');

-- --------------------------------------------------------

--
-- 表的结构 `jxshop_admin_role`
--

CREATE TABLE IF NOT EXISTS `jxshop_admin_role` (
  `admin_id` smallint(5) unsigned NOT NULL COMMENT '管理员Id',
  `role_id` smallint(5) unsigned NOT NULL COMMENT '角色Id',
  KEY `admin_id` (`admin_id`),
  KEY `role_id` (`role_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='管理员所在角色';

--
-- 转存表中的数据 `jxshop_admin_role`
--

INSERT INTO `jxshop_admin_role` (`admin_id`, `role_id`) VALUES
(3, 1);

-- --------------------------------------------------------

--
-- 表的结构 `jxshop_category`
--

CREATE TABLE IF NOT EXISTS `jxshop_category` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Id',
  `cat_name` varchar(150) NOT NULL COMMENT '��������',
  `parent_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '�ϼ�����ID,0����������',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='����' AUTO_INCREMENT=10 ;

--
-- 转存表中的数据 `jxshop_category`
--

INSERT INTO `jxshop_category` (`id`, `cat_name`, `parent_id`) VALUES
(1, '手机', 0),
(6, '书', 0),
(3, 'android', 1),
(8, 'oop', 1),
(7, 'PHP', 6),
(9, '魔术方法', 8);

-- --------------------------------------------------------

--
-- 表的结构 `jxshop_goods`
--

CREATE TABLE IF NOT EXISTS `jxshop_goods` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Id',
  `goods_name` varchar(150) NOT NULL COMMENT '商品名称',
  `market_price` decimal(10,2) NOT NULL COMMENT '市场价格',
  `shop_price` decimal(10,2) NOT NULL COMMENT '本店价格',
  `logo` varchar(150) NOT NULL DEFAULT '' COMMENT 'logo',
  `sm_logo` varchar(150) NOT NULL DEFAULT '' COMMENT '小的缩略图',
  `mid_logo` varchar(150) NOT NULL DEFAULT '' COMMENT '中的缩略图',
  `addtime` int(10) unsigned NOT NULL COMMENT '添加的时间',
  `is_on_sale` enum('是','否') NOT NULL DEFAULT '是' COMMENT '是否上架',
  `goods_desc` longtext COMMENT '商品描述',
  `cat_id` smallint(5) unsigned NOT NULL COMMENT '主分类id',
  PRIMARY KEY (`id`),
  KEY `shop_price` (`shop_price`),
  KEY `addtime` (`addtime`),
  KEY `is_on_sale` (`is_on_sale`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='商品' AUTO_INCREMENT=9 ;

-- --------------------------------------------------------

--
-- 表的结构 `jxshop_goods_cat`
--

CREATE TABLE IF NOT EXISTS `jxshop_goods_cat` (
  `goods_id` mediumint(8) unsigned NOT NULL COMMENT '商品Id',
  `cat_id` smallint(5) unsigned NOT NULL COMMENT '扩展分类Id',
  KEY `goods_id` (`goods_id`),
  KEY `cat_id` (`cat_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='商品所在扩展分类';

-- --------------------------------------------------------

--
-- 表的结构 `jxshop_privilege`
--

CREATE TABLE IF NOT EXISTS `jxshop_privilege` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Id',
  `pri_name` varchar(30) NOT NULL COMMENT '权限名称',
  `module_name` varchar(30) NOT NULL DEFAULT '' COMMENT '对应的模块名',
  `controller_name` varchar(30) NOT NULL DEFAULT '' COMMENT '对应的控制器名',
  `action_name` varchar(30) NOT NULL DEFAULT '' COMMENT '对应的方法名',
  `parent_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '上级权限id,0:代表顶级权限',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='权限' AUTO_INCREMENT=23 ;

--
-- 转存表中的数据 `jxshop_privilege`
--

INSERT INTO `jxshop_privilege` (`id`, `pri_name`, `module_name`, `controller_name`, `action_name`, `parent_id`) VALUES
(1, '商品管理', '', '', '', 0),
(2, '商品列表', 'Admin', 'Goods', 'lst', 1),
(3, '添加商品', 'Admin', 'Goods', 'add', 2),
(4, '修改商品', 'Admin', 'Goods', 'edit', 2),
(5, '删除商品', 'Admin', 'Goods', 'delete', 2),
(6, '分类列表', 'Admin', 'Category', 'lst', 1),
(7, '添加分类', 'Admin', 'Category', 'add', 6),
(8, '修改分类', 'Admin', 'Category', 'edit', 6),
(9, '删除分类', 'Admin', 'Category', 'delete', 6),
(10, 'RBAC', '', '', '', 0),
(11, '权限列表', 'Admin', 'Privilege', 'lst', 10),
(12, '添加权限', 'Privilege', 'Admin', 'add', 11),
(13, '修改权限', 'Admin', 'Privilege', 'edit', 11),
(14, '删除权限', 'Admin', 'Privilege', 'delete', 11),
(15, '角色列表', 'Admin', 'Role', 'lst', 10),
(16, '添加角色', 'Admin', 'Role', 'add', 15),
(17, '修改角色', 'Admin', 'Role', 'edit', 15),
(18, '删除角色', 'Admin', 'Role', 'delete', 15),
(19, '管理员列表', 'Admin', 'Admin', 'lst', 10),
(20, '添加管理员', 'Admin', 'Admin', 'add', 19),
(21, '修改管理员', 'Admin', 'Admin', 'edit', 19),
(22, '删除管理员', 'Admin', 'Admin', 'delete', 19);

-- --------------------------------------------------------

--
-- 表的结构 `jxshop_role`
--

CREATE TABLE IF NOT EXISTS `jxshop_role` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Id',
  `role_name` varchar(30) NOT NULL COMMENT '角色名称',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='角色' AUTO_INCREMENT=4 ;

--
-- 转存表中的数据 `jxshop_role`
--

INSERT INTO `jxshop_role` (`id`, `role_name`) VALUES
(1, '商品管理员'),
(2, '定单管理员');

-- --------------------------------------------------------

--
-- 表的结构 `jxshop_role_pri`
--

CREATE TABLE IF NOT EXISTS `jxshop_role_pri` (
  `role_id` smallint(5) unsigned NOT NULL COMMENT '角色Id',
  `pri_id` smallint(5) unsigned NOT NULL COMMENT '权限Id',
  KEY `role_id` (`role_id`),
  KEY `pri_id` (`pri_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='角色拥有的权限';

--
-- 转存表中的数据 `jxshop_role_pri`
--

INSERT INTO `jxshop_role_pri` (`role_id`, `pri_id`) VALUES
(1, 5),
(1, 4),
(1, 3),
(1, 2),
(1, 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
