<?php
namespace Admin\Controller;
use Think\Controller;
class BaseController extends Controller 
{
    public function __construct()
    {
    	// 先调用父类的构造函数
    	parent::__construct();
    	// 判断登录 
    	$id = session('id');
    	if(!$id)
    		$this->error('必须先登录！', U('Login/login'));
    	// 验证权限
    	$adminModel = D('Admin');
    	if(!$adminModel->chkPri())
    		$this->error('无权访问！');
    }
}