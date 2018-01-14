<?php
namespace Admin\Model;
use Think\Model;
class RoleModel extends Model 
{
	protected $insertFields = array('role_name');
	protected $updateFields = array('id','role_name');
	protected $_validate = array(
		array('role_name', 'require', '角色名称不能为空！', 1, 'regex', 3),
		array('role_name', '1,30', '角色名称的值最长不能超过 30 个字符！', 1, 'length', 3),
	);
	public function search($pageSize = 20)
	{
		/**************************************** 搜索 ****************************************/
		$where = array();
		if($role_name = I('get.role_name'))
			$where['role_name'] = array('like', "%$role_name%");
		/************************************* 翻页 ****************************************/
		$count = $this->alias('a')->where($where)->count();
		$page = new \Think\Page($count, $pageSize);
		// 配置翻页的样式
		$page->setConfig('prev', '上一页');
		$page->setConfig('next', '下一页');
		$data['page'] = $page->show();
		/************************************** 取数据 ******************************************/
		/*
		mysql> SELECT a.*,GROUP_CONCAT(c.pri_name) pri_name FROM jxshop_role a LEFT JOIN
 jxshop_role_pri b ON a.id=b.role_id LEFT JOIN jxshop_privilege c ON b.pri_id=c.
id GROUP BY a.id;*/
		$data['data'] = $this->alias('a')
		->field('a.*,GROUP_CONCAT(c.pri_name) pri_name')
		->join('LEFT JOIN jxshop_role_pri b ON a.id=b.role_id LEFT JOIN jxshop_privilege c ON b.pri_id=c.id')
		->where($where)
		->group('a.id')
		->limit($page->firstRow.','.$page->listRows)
		->select();
		//echo mysql_error();
		return $data;
	}
	protected function _after_insert($data, $option)
	{
		/**********8 处理权限 ***************/
		$priId = I('pri_id');
		if($priId)
		{
			$rpModel = M('RolePri');
			foreach ($priId as $k => $v)
			{
				$rpModel->add(array(
					'role_id' => $data['id'],
					'pri_id' => $v,
				));
			}
		}
	}
	// 添加前
	protected function _before_insert(&$data, $option)
	{
	}
	// 修改前
	protected function _before_update(&$data, $option)
	{
		/**********8 处理权限 ***************/
		// 先删除原数据
		$rpModel = M('RolePri');
		$rpModel->where(array(
			'role_id' => array('eq', $option['where']['id'])
		))->delete();
		$priId = I('pri_id');
		if($priId)
		{
			foreach ($priId as $k => $v)
			{
				$rpModel->add(array(
					'role_id' => $option['where']['id'],
					'pri_id' => $v,
				));
			}
		}
	}
	// 删除前
	protected function _before_delete($option)
	{
		$rpModel = M('RolePri');
		$rpModel->where(array(
			'role_id' => array('eq', $option['where']['id'])
		))->delete();
	}
	/************************************ 其他方法 ********************************************/
}