<?php
namespace Admin\Controller;
class GoodsController extends BaseController 
{
	public function ajaxDelImage()
	{
		$pid = I('get.pic_id');
		$gpModel = D('goods_pic');
		$pic = $gpModel->field('pic,sm_pic,mid_pic,big_pic')->find($pid);
		// 从硬盘上删除图片
		deleteImage($pic);
		// 从数据库中把相册记录删除
		$gpModel->delete($pid);
	}
	public function ajaxDelGoodsAttr()
	{
		$gaid = I('get.gaid');
		$gaModel = D('goods_attr');
		$gaModel->delete($gaid);
	}
	public function ajaxGetAttr()
	{
		$typeId = I('get.type_id');
		$attrModel = M('Attribute');
		$attrData = $attrModel->where(array(
			'type_id' => array('eq', $typeId),
		))->select();
		echo json_encode($attrData);
	}
	public function goods_number()
	{
		$id = I('get.id');
		$gnModel = D('goods_number');
		if(IS_POST)
		{
			// 删除原数据
			$gnModel->where(array(
				'goods_id' => array('eq', $id),
			))->delete();
			$gaid = I('post.gaid');
			$gn = I('post.gn');
			$gaidCount = count($gaid);
			$gnCount = count($gn);
			$rate = $gaidCount / $gnCount;
			$_i = 0;
			foreach ($gn as $k => $v)
			{
				$isempty = FALSE;
				$_attr_list = array();
				for($i=0; $i<$rate; $i++)
				{
					if(empty($gaid[$_i]))
						$isempty = TRUE;
					$_attr_list[] = $gaid[$_i];
					$_i++;
				}
				
				if(empty($v) || $isempty)
					continue;
					
				sort($_attr_list);
				$_attr_list = implode(',', $_attr_list);
				$gnModel->add(array(
					'goods_id' => $id,
					'goods_number' => $v,
					'attr_list' => $_attr_list,
				));
			}
			$this->success('成功！', U('lst'));
			exit;
		}
		// 先取出这件商品所有单选的属性
		$gaModel = D('goods_attr');
		$gaData = $gaModel->alias('a')
		->field('a.*,b.attr_name')
		->join('LEFT JOIN jxshop_attribute b ON a.attr_id=b.id')
		->where(array(
			'a.goods_id' => array('eq', $id),
			'b.attr_type' => array('eq', '可选'),
		))
		->select();
		// 把二维数组转成三维数组  --> 把相同属性的数据放到 一起
		$_gaData = array();
		foreach ($gaData as $k => $v)
		{
			$_gaData[$v['attr_id']][] = $v;
		}
		//var_dump($_gaData);
		// 取出已经设置好的库存量数据
		$gnData = $gnModel->where(array(
			'goods_id' => array('eq', $id),
		))->select();
		//var_dump($gnData);
		
		// 设置页面的信息
		$this->assign(array(
			'gaData' => $_gaData,
			'gnData' => $gnData,
			'_page_title' => '库存管理',
			'_page_btn_name' => '商品列表',
			'_page_btn_link' => U('lst'),
		));
		$this->display();
	}
	// 删除
	public function delete()
	{
		// 接收要删除的商品的ID
		$id = I('get.id');
		$model = D('Goods');
		if(FALSE !== $model->delete($id))
		{
			$this->success('删除成功！'); // 返回上一页面
			exit;
		}
		else 
			$this->error('删除失败！');
	}
	// 列表页
	public function lst()
	{
		$model = D('Goods');
		$data = $model->search();
		// 取出所有的分类
		$catModel = D('Category');
		$catData = $catModel->getTree();
		$this->assign('catData', $catData);
		$this->assign('data', $data['data']);
		$this->assign('page', $data['page']);
		// 设置页面的信息
		$this->assign(array(
			'_page_title' => '商品列表',
			'_page_btn_name' => '添加商品',
			'_page_btn_link' => U('add'),
		));
		$this->display();
	}
	// 修改
	public function edit()
	{
		$id = I('get.id'); // 要修改的商品在id
		// 判断是否提交了表单
		if(IS_POST)
		{
			// 生成商品模型
			$model = D('Goods');
			// 接收表单中的数据并且根据模型中定义的规则验证表单
			if($model->create(I('post.'), 2))
			{
				// 插入数据库
				if(FALSE !== $model->save())
				{
					// 提示成功，并在1秒之后跳到lst方法中
					$this->success('修改成功！', U('lst'));
					exit;
				}
			}
			// 获取失败的原因
			$error = $model->getError();
			// 打印错误信息
			$this->error($error);
		}
		// 取出要修改的商品信息
		$model = M('Goods');
		$info = $model->find($id);
		$this->assign('info', $info);
		// 取出当前商品所在类型下所有属性以及设置的属性值
		if($info['type_id'] != 0)
		{
			$attrModel = M('Attribute');
			$attrData = $attrModel->alias('a')
			->field('a.id attr_id,a.attr_name,a.attr_type,a.attr_option_value,b.id,b.attr_value')
			->join('LEFT JOIN jxshop_goods_attr b ON (a.id=b.attr_id AND b.goods_id='.$id.')')
			->where(array(
				'a.type_id' => array('eq', $info['type_id']),
			))->select();
			$this->assign('attrData', $attrData);
		}
		// 取出所有的分类
		$catModel = D('Category');
		$catData = $catModel->getTree();
		// 取出商品所在的扩展分类的ID
		$gcModel = M('GoodsCat');
		$ecatId = $gcModel->field('cat_id')->where(array(
			'goods_id' => array('eq', $id),
		))->select();
		// 取出所有的类型
		$typeModel = M('Type');
		$typeData = $typeModel->select();
		// 取出商品相册图片
		$gpModel = D('goods_pic');
		$gpData = $gpModel->field('id,mid_pic')->where(array(
			'goods_id' => array('eq', $id),
		))->select();
		// 取出会员级别
		$mlModel = D('member_level');
		$mlData = $mlModel->select();
		// 取出已经设置好的会员价格数据
		$mpModel = D('member_price');
		$mpData = $mpModel->where(array(
			'goods_id' => array('eq', $id),
		))->select();
		// 把二维转一维：结构：  array(
		//	级别ID  =>  价格
		//) 找一个级别价格时直接可以$rp[级别ID]
		$_mpData = array();
		foreach ($mpData as $k => $v)
		{
			$_mpData[$v['level_id']] = $v['price'];
		}
		// 设置页面的信息
		$this->assign(array(
			'mpData' => $_mpData,
			'mlData' => $mlData,
			'gpData' => $gpData,
			'typeData' => $typeData,
			'ecatId' => $ecatId,
			'catData' => $catData,
			'_page_title' => '商品修改',
			'_page_btn_name' => '商品列表',
			'_page_btn_link' => U('lst'),
		));
		// 1. 显示表单
		$this->display();
	}
	// 添加
	public function add()
	{
		// 判断是否提交了表单
		if(IS_POST)
		{
			//var_dump($_POST);die;
			// 生成商品模型
			$model = D('Goods');
			// 接收表单中的数据并且根据模型中定义的规则验证表单
			if($model->create(I('post.'), 1))
			{
				// 插入数据库
				if($model->add())
				{
					// 提示成功，并在1秒之后跳到lst方法中
					$this->success('添加成功！', U('lst'));
					exit;
				}
			}
			// 获取失败的原因
			$error = $model->getError();
			// 打印错误信息
			$this->error($error);
		}
		// 取出所有的分类
		$catModel = D('Category');
		$catData = $catModel->getTree();
		// 取出所有的类型
		$typeModel = M('Type');
		$typeData = $typeModel->select();
		// 取出会员级别
		$mlModel = D('member_level');
		$mlData = $mlModel->select();
		// 设置页面的信息
		$this->assign(array(
			'mlData' => $mlData,
			'typeData' => $typeData,
			'catData' => $catData,
			'_page_title' => '商品添加',
			'_page_btn_name' => '商品列表',
			'_page_btn_link' => U('lst'),
		));
		// 1. 显示表单
		$this->display();
	}
}