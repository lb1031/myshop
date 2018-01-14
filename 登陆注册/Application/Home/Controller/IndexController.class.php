<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index()
    {
    	$gModel = D('Admin/Goods');
    	/*************** 取出抢购的商品 **************/
    	$goods1 = $gModel->getPromoteGoods();
    	$goods2 = $gModel->getRecGoods('is_new');
    	$goods3 = $gModel->getRecGoods('is_rec');
    	$goods4 = $gModel->getRecGoods('is_hot');
    	/************** 楼层分类获取 ****************/
    	$cModel = D('Admin/Category');
    	$recCat = $cModel->getRecCat();
    	
    	// 设置页面信息
    	$this->assign(array(
    		'recCat' => $recCat,
    		'goods1' => $goods1,
    		'goods2' => $goods2,
    		'goods3' => $goods3,
    		'goods4' => $goods4,
    		'show_nav' => 1,
    		'_page_title' => '首页',
    		'_page_keywords' => '首页',
    		'_page_description' => '首页',
    	));
		$this->display();
    }
    public function goods()
    {
    	// 设置页面信息
    	$this->assign(array(
    		'_page_title' => '商品详情页',
    		'_page_keywords' => '商品详情页',
    		'_page_description' => '商品详情页',
    	));
		$this->display();
    }
}