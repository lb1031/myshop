<?php
namespace Admin\Model;
use Think\Model;
class AdminModel extends Model 
{
	protected $insertFields = array('username','password','chk_code');
	protected $updateFields = array('id','username','password');
	// 登录时使用的表单验证规则
	public $_login_validate = array(
		array('chk_code', 'require', '验证码不能为空！', 1),
		array('chk_code', 'chk_code', '验证码不正确！', 1, 'callback'),
		array('username', 'require', '账号不能为空！', 1),
		array('password', 'require', '密码不能为空！', 1)
	);
	protected function chk_code($code)
	{
		$verify = new \Think\Verify();
    	return $verify->check($code);
	}
	// 添加和修改管理员时使用的表单验证规则
	protected $_validate = array(
		array('username', 'require', '账号不能为空！', 1, 'regex', 3),
		array('username', '1,30', '账号的值最长不能超过 30 个字符！', 1, 'length', 3),
		array('password', 'require', '密码不能为空！', 1, 'regex', 3),
		array('password', '1,32', '密码的值最长不能超过 32 个字符！', 1, 'length', 3),
	);
	// 登录 
	public function login()
	{
		// 先取出用户提交的用户名和密码
		// 可以从模型中取，因为我们会在控制器中调用模型的create方法接收表单【$model->create()】，这个方法就接收表单数据并放到模型中的
		$username = $this->username;
		$password = $this->password;
		// 账号是否存在 
		$user = $this->where(array(
			'username' => array('eq', $username)
		))->find();
		if($user)
		{
			if($user['password'] == md5($password))
			{
				// 登录成功把ID和username存到session中
				session('id', $user['id']);
				session('username', $user['username']);
				return TRUE;
			}
			else 
			{
				$this->error = '密码不正确！';
				return FALSE;
			}
		}
		else 
		{
			$this->error = '账号不存在！';
			return FALSE;
		}
	}
	public function search($pageSize = 20)
	{
		/**************************************** 搜索 ****************************************/
		$where = array();
		if($username = I('get.username'))
			$where['username'] = array('like', "%$username%");
		/************************************* 翻页 ****************************************/
		$count = $this->alias('a')->where($where)->count();
		$page = new \Think\Page($count, $pageSize);
		// 配置翻页的样式
		$page->setConfig('prev', '上一页');
		$page->setConfig('next', '下一页');
		$data['page'] = $page->show();
		/************************************** 取数据 ******************************************/
		$data['data'] = $this->alias('a')->where($where)->group('a.id')->limit($page->firstRow.','.$page->listRows)->select();
		return $data;
	}
	protected function _after_insert($data, $option)
	{
		/************ 处理角色 ***********/
		$rid = I('post.rid');
		if($rid)
		{
			$arModel = M('AdminRole');
			foreach ($rid as $k => $v)
			{
				$arModel->add(array(
					'admin_id' => $data['id'],
					'role_id' => $v,
				));
			}
		}
	}
	// 判断是否有权限访问当前页面
	public function chkPri()
	{
		// 后台首页可以直接访问
		if(CONTROLLER_NAME == 'Index')
			return TRUE;
		$id = session('id'); // 管理员id
		// 超级管理员有所有权限
		if($id == 1)
			return TRUE;
		// 查询一个管理员是否有权限访问的SQL：1. 根据管理员ID取出这个管理员所在的角色的ID 2. 再取出这些角色所拥有的权限 3. 判断是否有一个权限和当前地址对应
		$sql = 'SELECT COUNT(c.id) has
				 FROM jxshop_admin_role a
				  LEFT JOIN jxshop_role_pri b ON a.role_id=b.role_id 
				  LEFT JOIN jxshop_privilege c ON b.pri_id=c.id
				  WHERE a.admin_id='.$id.' AND c.module_name="'.MODULE_NAME.'" AND c.controller_name="'.CONTROLLER_NAME.'" AND c.action_name="'.ACTION_NAME.'"';
		$has = $this->query($sql);
		return ($has[0]['has'] > 0);
	}
	// 添加前
	protected function _before_insert(&$data, $option)
	{
		$data['password'] = md5($data['password']);
	}
	// 修改前
	protected function _before_update(&$data, $option)
	{
		$data['password'] = md5($data['password']);
		/************ 处理角色 ***********/
		$arModel = M('AdminRole');
		// 先删除原角色的数据
		$arModel->where(array(
			'admin_id' => array('eq', $option['where']['id']),
		))->delete();
		$rid = I('post.rid');
		if($rid)
		{
			foreach ($rid as $k => $v)
			{
				$arModel->add(array(
					'admin_id' => $option['where']['id'],
					'role_id' => $v,
				));
			}
		}		
	}
	// 取出当前管理员所拥有的前两级的权限
	public function getBtns()
	{
		/************* 取出当前管理员所拥有的所有的权限 *******************/
		$priModel = M('Privilege');
		$id = session('id'); // 当前管理员的id
		if($id == 1)
			// 超级管理员拥有所有的权限
			$priData = $priModel->select();
		else 
		{
			$sql = 'SELECT c.*
				 FROM jxshop_admin_role a
				  LEFT JOIN jxshop_role_pri b ON a.role_id=b.role_id 
				  LEFT JOIN jxshop_privilege c ON b.pri_id=c.id
				  WHERE a.admin_id='.$id;
			$priData = $this->query($sql);
		}
		/************** 从所有的权限中提取出前两级的权限 **********************/
		$ret = array();
		foreach ($priData as $k => $v)
		{
			// 先提取出顶级的
			if($v['parent_id'] == 0)
			{
				// 再提取这个顶级的子权限
				foreach ($priData as $k1 => $v1)
				{
					if($v1['parent_id'] == $v['id'])
					{
						$v['children'][] = $v1; // 把这个二级权限，放到顶级权限的children数组中
					}
				}
				// 把顶级权限放到另一个数组中
				$ret[] = $v;
			}
		}
		return $ret;
	}
	// 删除前
	protected function _before_delete($option)
	{
		/************** 删除管理员角色表中对应的数据 ***********/
		$arModel = M('AdminRole');
		$arModel->where(array(
			'admin_id' => array('eq', $option['where']['id']),
		))->delete();
	}
	/************************************ 其他方法 ********************************************/
}