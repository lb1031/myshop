<?php
namespace Admin\Controller;
use Think\Controller;
class LoginController extends Controller 
{
	// 生成验证码图片
	public function chk_code()
	{
		$Verify = new \Think\Verify(array(
		    'length'      =>    2,     // 验证码位数
		    'useNoise'    =>    false, // 关闭验证码杂点
		));
		$Verify->entry();
	}
    public function login()
    {
    	if(IS_POST)
    	{
    		$model = D('Admin');
    		// 使用我们定义的登录的规则来验证
    		if($model->validate($model->_login_validate)->create())
    		{
    			if($model->login())
    			{
    				$this->success('登录成功！', U('Admin/Index/index'));
    				exit;
    			}
    		}
    		$this->error($model->getError());
    	}
    	// 1. 显示登录的表单
		$this->display();
    }
}