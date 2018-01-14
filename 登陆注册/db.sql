CREATE DATABASE IF NOT EXISTS jxshop;
USE jxshop;
SET NAMES utf8;

DROP TABLE IF EXISTS jxshop_goods;
CREATE TABLE jxshop_goods
(
	id mediumint unsigned not null auto_increment comment 'Id',
	goods_name varchar(150) not null comment '商品名称',
	market_price decimal(10,2) not null comment '市场价格',
	shop_price decimal(10,2) not null comment '本店价格',
	logo varchar(150) not null default '' comment 'logo',
	sm_logo varchar(150) not null default '' comment '小的缩略图',
	mid_logo varchar(150) not null default '' comment '中的缩略图',
	addtime int unsigned not null comment '添加的时间',
	is_on_sale enum('是','否') not null default '是' comment '是否上架',
	goods_desc longtext comment '商品描述',
	cat_id smallint unsigned not null comment '主分类id',
	type_id smallint unsigned not null default '0' comment '类型的id',
	promote_price decimal(10,2) not null default '0.00' comment '促销价格',
	promote_start_date datetime not null default '0000-00-00 00:00:00' comment '促销价格',
	promote_end_date datetime not null default '0000-00-00 00:00:00' comment '促销价格',
	is_new enum('是','否') not null default '否' comment '是否新品', 
	is_rec enum('是','否') not null default '否' comment '是否推荐', 
	is_hot enum('是','否') not null default '否' comment '是否热销', 
	primary key (id),
	key shop_price(shop_price),
	key addtime(addtime),
	key is_on_sale(is_on_sale),
	key cat_id(cat_id)
)engine=MyISAM default charset=utf8 comment '商品';

DROP TABLE IF EXISTS jxshop_goods_cat;
CREATE TABLE jxshop_goods_cat
(
	goods_id mediumint unsigned not null comment '商品Id',
	cat_id smallint unsigned not null comment '扩展分类Id',
	key goods_id(goods_id),
	key cat_id(cat_id)
)engine=MyISAM default charset=utf8 comment '商品所在扩展分类';

DROP TABLE IF EXISTS jxshop_category;
CREATE TABLE jxshop_category
(
	id smallint unsigned not null auto_increment comment 'Id',
	cat_name varchar(150) not null comment '分类名称',
	parent_id smallint unsigned not null default '0' comment '上级分类ID,0：顶级分类',
	is_rec enum('是','否') not null default '否' comment '是否推荐', 
	primary key (id)
)engine=MyISAM default charset=utf8 comment '分类';

/********************** RBAC ********************************/
DROP TABLE IF EXISTS jxshop_privilege;
CREATE TABLE jxshop_privilege
(
	id smallint unsigned not null auto_increment comment 'Id',
	pri_name varchar(30) not null comment '权限名称',
	module_name varchar(30) not null default '' comment '对应的模块名',
	controller_name varchar(30) not null default '' comment '对应的控制器名',
	action_name varchar(30) not null default '' comment '对应的方法名',
	parent_id smallint unsigned not null default '0' comment '上级权限id,0:代表顶级权限',
	primary key (id)
)engine=MyISAM default charset=utf8 comment '权限';

DROP TABLE IF EXISTS jxshop_role_pri;
CREATE TABLE jxshop_role_pri
(
	role_id smallint unsigned not null comment '角色Id',
	pri_id smallint unsigned not null comment '权限Id',
	key role_id(role_id),
	key pri_id(pri_id)
)engine=MyISAM default charset=utf8 comment '角色拥有的权限';

DROP TABLE IF EXISTS jxshop_role;
CREATE TABLE jxshop_role
(
	id smallint unsigned not null auto_increment comment 'Id',
	role_name varchar(30) not null comment '角色名称',
	primary key (id)
)engine=MyISAM default charset=utf8 comment '角色';

DROP TABLE IF EXISTS jxshop_admin_role;
CREATE TABLE jxshop_admin_role
(
	admin_id smallint unsigned not null comment '管理员Id',
	role_id smallint unsigned not null comment '角色Id',
	key admin_id(admin_id),
	key role_id(role_id)
)engine=MyISAM default charset=utf8 comment '管理员所在角色';

DROP TABLE IF EXISTS jxshop_admin;
CREATE TABLE jxshop_admin
(
	id smallint unsigned not null auto_increment comment 'Id',
	username varchar(30) not null comment '账号',
	password char(32) not null comment '密码',
	primary key (id)
)engine=MyISAM default charset=utf8 comment '管理员';
INSERT INTO jxshop_admin VALUES(1,'root','21232f297a57a5a743894a0e4a801fc3');

DROP TABLE IF EXISTS jxshop_type;
CREATE TABLE jxshop_type
(
	id smallint unsigned not null auto_increment comment 'Id',
	type_name varchar(30) not null comment '类型名称',
	primary key (id)
)engine=MyISAM default charset=utf8 comment '类型';

DROP TABLE IF EXISTS jxshop_attribute;
CREATE TABLE jxshop_attribute
(
	id mediumint unsigned not null auto_increment comment 'Id',
	attr_name varchar(30) not null comment '属性名称',
	attr_type enum('可选','唯一') not null default '唯一' comment '属性的类型',
	attr_option_value varchar(150) not null default '' comment '属性的可选值，多个值用，隔开',
	type_id smallint unsigned not null comment '类型的id',
	primary key (id),
	key type_id(type_id)
)engine=MyISAM default charset=utf8 comment '属性';

DROP TABLE IF EXISTS jxshop_goods_attr;
CREATE TABLE jxshop_goods_attr
(
	id mediumint unsigned not null auto_increment comment 'Id',
	goods_id mediumint unsigned not null comment '商品的id',
	attr_id mediumint unsigned not null comment '属性的id',
	attr_value varchar(150) not null default '' comment '属性值',
	primary key (id),
	key goods_id(goods_id),
	key attr_id(attr_id)
)engine=MyISAM default charset=utf8 comment '商品属性';

DROP TABLE IF EXISTS jxshop_goods_pic;
CREATE TABLE jxshop_goods_pic
(
	id mediumint unsigned not null auto_increment comment 'Id',
	goods_id mediumint unsigned not null comment '商品的id',
	pic varchar(150) not null comment '原图',
	sm_pic varchar(150) not null comment '小图',
	mid_pic varchar(150) not null comment '中图',
	big_pic varchar(150) not null comment '大图',
	primary key (id),
	key goods_id(goods_id)
)engine=MyISAM default charset=utf8 comment '商品相册';

DROP TABLE IF EXISTS jxshop_member_level;
CREATE TABLE jxshop_member_level
(
	id mediumint unsigned not null auto_increment comment 'Id',
	level_name varchar(30) not null comment '级别名称',
	jifen_bottom mediumint unsigned not null comment '积分下限',
	jifen_top mediumint unsigned not null comment '积分上限',
	primary key (id)
)engine=MyISAM default charset=utf8 comment '会员级别';

DROP TABLE IF EXISTS jxshop_member_price;
CREATE TABLE jxshop_member_price
(
	goods_id mediumint unsigned not null comment '商品Id',
	level_id mediumint unsigned not null comment '级别Id',
	price decimal(10,2) not null comment '价格',
	key goods_id(goods_id)
)engine=MyISAM default charset=utf8 comment '会员价格';

DROP TABLE IF EXISTS jxshop_goods_number;
CREATE TABLE jxshop_goods_number
(
	goods_id mediumint unsigned not null comment '商品Id',
	goods_number mediumint unsigned not null comment '库存量',
	attr_list varchar(150) not null default '' comment '多个商品属性的ID，多个用，隔开',
	key goods_id(goods_id)
)engine=MyISAM default charset=utf8 comment '库存量';

DROP TABLE IF EXISTS jxshop_member;
CREATE TABLE jxshop_member
(
	id mediumint unsigned not null auto_increment comment 'Id',
	username varchar(30) not null comment '用户名',
	password char(32) not null comment '密码',
	jifen mediumint unsigned not null default '0' comment '积分',
	primary key (id)
)engine=MyISAM default charset=utf8 comment '会员';










