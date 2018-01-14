<?php
namespace Home\Model;
use Think\Model;
class MemberModel extends Model 
{
	protected $insertFields = 'username,password,cpassword,chkcode';
	
	protected $_validate = array(
		array('chkcode', 'require', '验证码不能为空！', 1),
		array('chkcode', 'chkcode', '验证码输入不正确！', 1, 'callback'),
		array('username', 'require', '用户名不能为空！', 1),
		array('password', 'require', '密码不能为空！', 1),
		array('cpassword', 'password', '两次密码输入不一致！', 1, 'confirm'),
		array('username', '', '该用户名已经存在！', 1, 'unique'),
	);
	protected function chkcode($code)
	{
		$verify = new \Think\Verify();
    	return $verify->check($code);
	}
	protected function _before_insert(&$data, $option)
	{
		$data['password'] = md5($data['password']);
	}
}