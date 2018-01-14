<?php
namespace Admin\Model;
use Think\Model;
class TypeModel extends Model 
{
	protected $insertFields = array('type_name');
	protected $updateFields = array('id','type_name');
	protected $_validate = array(
		array('type_name', 'require', '类型名称不能为空！', 1, 'regex', 3),
		array('type_name', '1,30', '类型名称的值最长不能超过 30 个字符！', 1, 'length', 3),
	);
	public function search($pageSize = 20)
	{
		/**************************************** 搜索 ****************************************/
		$where = array();
		if($type_name = I('get.type_name'))
			$where['type_name'] = array('like', "%$type_name%");
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
	// 添加前
	protected function _before_insert(&$data, $option)
	{
	}
	// 修改前
	protected function _before_update(&$data, $option)
	{
	}
	// 删除前
	protected function _before_delete($option)
	{
		// 删除类型下的属性
		$attrModel = M('Attribute');
		$attrModel->where(array(
			'type_id' => array('eq', $option['where']['id'])
		))->delete();
	}
	/************************************ 其他方法 ********************************************/
}