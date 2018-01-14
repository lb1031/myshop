<?php
namespace Home\Controller;
use Think\Controller;
class MemberController extends Controller 
{
	public function chkcode()
	{
		$Verify = new \Think\Verify();
		$Verify->entry();
	}
    public function regist()
    {
    	if(IS_POST)
    	{
    		$model = D('member');
    		if($model->create(I('post.'), 1))
    		{
    			if($model->add())
    			{
    				$this->success('注册成功！', U('login'));
    				exit;
    			}
    		}
    		$this->error($model->getError());
    	}
    	// 设置页面信息
    	$this->assign(array(
    		'_page_title' => '注册',
    		'_page_keywords' => '注册',
    		'_page_description' => '注册',
    	));
    	$this->display();
    }
    public function login()
    {
    	
    }
}