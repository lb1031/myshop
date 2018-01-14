<?php
namespace Admin\Model;
use Think\Model;
class CategoryModel extends Model
{
	// 设置添加时允许接收的字段
	protected $insertFields = 'cat_name,parent_id,is_rec';
	// 设置修改时允许接收的字段
	protected $updateFields = 'id,cat_name,parent_id,is_rec';
	// 设置表单数据的验证规则
	protected $_validate = array(
		array('cat_name', 'require', '分类名称不能为空!', 1),
	);
	// 获取树形结构的数据
	public function getTree()
	{
		$data = $this->select();
		return $this->_getTree($data);
	}
	// 递归排序成树形
	private function _getTree($data, $parent_id=0, $level=0)
	{
		static $_ret = array();
		foreach ($data as $k => $v)
		{
			if($v['parent_id'] == $parent_id)
			{
				$v['level'] = $level;
				$_ret[] = $v;
				$this->_getTree($data, $v['id'], $level+1);
			}
		}
		return $_ret;
	}
	// 取一个分类所有子分类的ID
	public function getChildren($catId)
	{
		$data = $this->select();  // 取出所有的分类
		return $this->_getChildren($data, $catId, TRUE);
	}
	private function _getChildren($data, $parent_id, $isClear = FALSE)
	{
		static $_ret = array();
		if($isClear)
			$_ret = array();
		foreach ($data as $k => $v)
		{
			if($v['parent_id'] == $parent_id)
			{
				$_ret[] = $v['id'];
				$this->_getChildren($data, $v['id']);
			}
		}
		return $_ret;
	}
	protected function _before_delete($option)
	{
		$children = $this->getChildren($option['where']['id']);
		if($children)
		{
			$children = implode(',', $children);
			$this->execute("DELETE FROM jxshop_category WHERE id IN($children)");
		}
	}
	/**
	 * 获取前台导航条上分类数据
	 *
	 */
	public function getNavData()
	{
		$data = $this->select();
		$ret = array();
		// 找出顶级分类
		foreach ($data as $k => $v)
		{
			if($v['parent_id'] == 0)
			{
				// 找出二级分类
				foreach ($data as $k1 => $v1)
				{
					if($v1['parent_id'] == $v['id'])
					{
						// 找出三级分类
						foreach ($data as $k2 => $v2)
						{
							if($v2['parent_id'] == $v1['id'])
							{
								$v1['children'][] = $v2;
							}
						}
						$v['children'][] = $v1;
					}
				}
				$ret[] = $v;
			}
		}
		return $ret;
	}
	
	/**
	 * 获取推荐的分类
	 *
	 */
	public function getRecCat()
	{
		// 顶级楼层
		$data = $this->where(array(
			'is_rec' => array('eq', '是'),
			'parent_id' => array('eq', 0),
		))->select();
		// 循环每个楼层，取出楼层中的数据
		foreach ($data as $k => $v)
		{
			// 取出二级分类，并保存到顶级分类的subCat字段中
			$data[$k]['subCat'] = $this->where(array(
				'parent_id' => $v['id']
			))->select();
			// 取出推荐的二级分类
			$data[$k]['recSubCat'] = $this->where(array(
				'parent_id' => $v['id'],
				'is_rec' => array('eq', '是'),
			))->select();
				// 循环每个推荐的二级分类取出8件商品
				foreach ($data[$k]['recSubCat'] as $k1 => $v1)
				{
					$data[$k]['recSubCat'][$k1]['goods'] = $this->getGoodsByCatId($v1['id'], 8);
				}
		}
		return $data;
	}
	
	/**
	 * 获取某一个分类下所有的商品
	 *
	 * @param unknown_type $catId ： 分类ID
	 * @param unknown_type $limit ： 获取几个
	 */
	public function getGoodsByCatId($catId, $limit)
	{
		$children = $this->getChildren($catid);
		$children[] = $catId;
		$gModel = D('goods');
		return $gModel->field('id,goods_name,shop_price,sm_logo')->where(array(
			'is_on_sale' => array('eq', '是'),
			'cat_id' => array('in', $children),
		))->limit($limit)->select();
	}
}












