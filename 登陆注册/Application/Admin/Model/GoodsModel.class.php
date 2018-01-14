<?php
namespace Admin\Model;
use Think\Model;
class GoodsModel extends Model
{
	
	// 设置添加时允许接收的字段
	protected $insertFields = 'goods_name,market_price,shop_price,is_on_sale,goods_desc,cat_id,type_id,promote_price,promote_start_date,promote_end_date,is_new,is_rec,is_hot';
	// 设置修改时允许接收的字段
	protected $updateFields = 'id,goods_name,market_price,shop_price,is_on_sale,goods_desc,cat_id,type_id,promote_price,promote_start_date,promote_end_date,is_new,is_rec,is_hot';
	// 设置表单数据的验证规则
	protected $_validate = array(
		array('cat_id', 'require', '必须选择一个主分类!', 1),
		array('goods_name', 'require', '商品名称不能为空!', 1),
		array('market_price', 'currency', '市场价格必须中货币类型!', 1),
		array('shop_price', 'currency', '本店价格必须中货币类型!', 1),
	);
	
	// 在数据添加到数据库之前自动被调用 
	protected function _before_insert(&$data, $option)
	{
		// 商品描述有选择性的过滤
		$data['goods_desc'] = clearXSS($_POST['goods_desc']);
		// 把当前时间补到表单中
		$data['addtime'] = time();
		/**** 处理表单中上传的LOGO图片 *****/
		// 判断用户有没有选择图片
		if(isset($_FILES['logo']) && $_FILES['logo']['error'] == 0)
		{
			// 上传图片
			 $upload = new \Think\Upload(array(
			 	'maxSize' => 2 * 1024 * 1024,
			 	'exts' => array('jpg', 'gif', 'png', 'jpeg'),
			 	'rootPath' => './Public/Uploads/',
			 	'savePath' => 'Goods/',
			 ));
		    // 上传文件 
		    $info   =   $upload->upload();
		    if($info)
		    {
		    	/*************** 生成缩略图 ****************/
		    	// 先取出刚刚上传成功的图片的路径和名称
		    	$logo = $info['logo']['savepath'] . $info['logo']['savename'];
		    	// 拼出缩略图的名字
		    	$sm_logo = $info['logo']['savepath'] .'sm_'. $info['logo']['savename'];
		    	$mid_logo = $info['logo']['savepath'] .'mid_'. $info['logo']['savename'];
		    	// 生成缩略图
		    	$image = new \Think\Image(); 
		    	$image->open('./Public/Uploads/'.$logo);
		    	$image->thumb(650, 650)->save('./Public/Uploads/'.$mid_logo);
		    	$image->thumb(130, 130)->save('./Public/Uploads/'.$sm_logo);
		    	// 把生成好的图片的路径放到表单中
		    	$data['logo'] = $logo;
		    	$data['sm_logo'] = $sm_logo;
		    	$data['mid_logo'] = $mid_logo;
		    }
		    else 
		    {
		    	// 先把错误信息保存到模型中，然后返回控制器，由控制器再从模型中取出错误原因并显示
		    	$this->error = $upload->getError();
				return FALSE;
		    }
		}
	}
	
	// 数据添加到数据库中之后,$data['id']就是新添加的记录的ID
	protected function _after_insert($data, $option)
	{
		/**************************** 处理商品相册 **************************************/
		if(hasImage('pic'))
		{
			// 重新处理数组
			$pics = array();
			foreach ($_FILES['pic']['name'] as $k => $v)
			{
				if(empty($v))
					continue;
				$pics[] = array(
					'name' => $v,
					'type' => $_FILES['pic']['type'][$k],
					'tmp_name' => $_FILES['pic']['tmp_name'][$k],
					'error' => $_FILES['pic']['error'][$k],
					'size' => $_FILES['pic']['size'][$k],
				);
			}
			$_FILES = $pics;  // uploadOne函数中会到$_FILES数组中找图片，所以把处理好的图片信息传到这里
			// 循环这个数组然后一个一个上传并生成缩略图
			$gpModel = D('goods_pic');
			foreach ($pics as $k => $v)
			{
				$ret = uploadOne($k, 'Goods', array(
					array(650, 650),
					array(330, 330),
					array(50, 50),
				));
				$gpModel->add(array(
					'goods_id' => $data['id'],
					'pic' => $ret['images'][0],
					'big_pic' => $ret['images'][1],
					'mid_pic' => $ret['images'][2],
					'sm_pic' => $ret['images'][3],
				));
			}
		}
		/************** 处理商品属性 *************/
		$attrId = I('post.attr_id');
		$goodsAttr = I('post.goods_attr');
		if($goodsAttr)
		{
			$gaModel = M('GoodsAttr');
			foreach ($goodsAttr as $k => $v)
			{
				$gaModel->add(array(
					'goods_id' => $data['id'],
					'attr_id' => $attrId[$k],
					'attr_value' => $v,
				));
			}
		}
		/************** 处理扩展分类 ************/
		$extCatId = I('ext_cat_id');
		if($extCatId)
		{
			// 生成商品分类表模型
			$gcModel = M('GoodsCat');
			foreach ($extCatId as $v)
			{
				// 如果没有选择分类就跳过
				if(empty($v))
					continue ;
				// 插入到商品分类表中
				$gcModel->add(array(
					'goods_id' => $data['id'],
					'cat_id' => $v,
				));
			}
		}
		/******************* 处理会员价格 ************************/
		$mp = I('post.member_price');
		$lid = I('post.level_id');
		$mpModel = D('member_price');
		foreach ($mp as $k => $v)
		{
			$_v = (float)$v;
			if($_v > 0)
				$mpModel->add(array(
					'level_id' => $lid[$k],
					'price' => $v,
					'goods_id' => $data['id'],
				));
		}
	}
	
	public function search()
	{
		/**************** 搜索 **************/
		$where = array();
		// 根据商品名称搜索
		if($gn = I('get.gn'))
			$where['goods_name'] = array('like', "%$gn%");
		// 价格搜索商品
		$fp = I('get.fp');
		$tp = I('get.tp');
		if($fp && $tp)
			$where['shop_price'] = array('between', array($fp, $tp));
		elseif ($fp)
			$where['shop_price'] = array('egt', $fp);
		elseif ($tp)
			$where['shop_price'] = array('elt', $fp);
		// 是否上架
		$ios = I('get.ios');
		if($ios == '是' || $ios == '否')
			$where['is_on_sale'] = array('eq', $ios);
		// 分类的搜索
		$catId = I('get.cat_id');
		if($catId)
		{
			// 先取出这个分类所有子分类的ID
			$catModel = D('Category');
			$children = $catModel->getChildren($catId);
			// 分类ID和子分类ID放到一起
			$children[] = $catId;
			$children = implode(',', $children);
			// 主分类或者扩展分类在$children这些分类下的商品
			// 先从商品分类表中取出扩展分类下的商品
			$gcModel = M('GoodsCat');
			$extGoodsId = $gcModel->field('GROUP_CONCAT(goods_id) gid')->where(array(
				'cat_id' => array('in', $children),
			))->find();
			if($extGoodsId['gid'])
				$orwhere = " OR id IN({$extGoodsId['gid']})";
			else 
				$orwhere = '';
			$where['cat_id'] = array('exp', "IN ($children) $orwhere");
		}
		/********************* 翻页 ************************/
		// 取总记录数
		$count = $this->where($where)->count();
		// 生成翻页类对象
		$page = new \Think\Page($count, 15);
		// 生成翻页的字符串
		$pageString = $page->show();
		/******************* 取数据 *****************/
		$data = $this->where($where)->limit($page->firstRow.','.$page->listRows)->select();
		
		return array(
			'data' => $data,
			'page' => $pageString,
		);
	}
	
	protected function _before_delete($option)
	{
		/*************** 删除原图片 ******************/
	    // 取出原图
		$oldLogo = $this->field('sm_logo,mid_logo,logo')->find($option['where']['id']);
		// 删除原图
		@unlink('./Public/Uploads/'.$oldLogo['sm_logo']);
    	@unlink('./Public/Uploads/'.$oldLogo['mid_logo']);
    	@unlink('./Public/Uploads/'.$oldLogo['logo']);
    	/************** 删除商品分类表中扩展分类的数据 **************/
    	$gcModel = M('GoodsCat');
    	$gcModel->where(array(
    		'goods_id' => array('eq', $option['where']['id'])
    	))->delete();
    	/*************** 删除商品属性 ******************/
    	$gaModel = D('goods_attr');
    	$gaModel->where('goods_id='.$option['where']['id'])->delete();
    	/*************** 删除相册 ******************/
    	$gpModel = D('goods_pic');
    	// 从硬盘删除图片
    	$pics = $gpModel->field('pic,sm_pic,mid_pic,big_pic')->where('goods_id='.$option['where']['id'])->select();
    	foreach ($pics as $v)
    	{
    		deleteImage($v);
    	}
    	$gpModel->where('goods_id='.$option['where']['id'])->delete();
	}
	
	// 修改前会自动执行
	protected function _before_update(&$data, $option)
	{
		/**************************** 处理商品相册 **************************************/
		if(hasImage('pic'))
		{
			// 重新处理数组
			$pics = array();
			foreach ($_FILES['pic']['name'] as $k => $v)
			{
				if(empty($v))
					continue;
				$pics[] = array(
					'name' => $v,
					'type' => $_FILES['pic']['type'][$k],
					'tmp_name' => $_FILES['pic']['tmp_name'][$k],
					'error' => $_FILES['pic']['error'][$k],
					'size' => $_FILES['pic']['size'][$k],
				);
			}
			$_FILES = $pics;  // uploadOne函数中会到$_FILES数组中找图片，所以把处理好的图片信息传到这里
			// 循环这个数组然后一个一个上传并生成缩略图
			$gpModel = D('goods_pic');
			foreach ($pics as $k => $v)
			{
				$ret = uploadOne($k, 'Goods', array(
					array(650, 650),
					array(330, 330),
					array(50, 50),
				));
				$gpModel->add(array(
					'goods_id' => $option['where']['id'],
					'pic' => $ret['images'][0],
					'big_pic' => $ret['images'][1],
					'mid_pic' => $ret['images'][2],
					'sm_pic' => $ret['images'][3],
				));
			}
		}
		/*********************** 修改扩展分类 ***************************/
		$extCatId = I('ext_cat_id');
		// 生成商品分类表模型
		$gcModel = M('GoodsCat');
		// 先删除原扩展分类数据
		$gcModel->where(array(
			'goods_id' => array('eq', $option['where']['id']),
		))->delete();	
		if($extCatId)
		{
			foreach ($extCatId as $v)
			{
				// 如果没有选择分类就跳过
				if(empty($v))
					continue ;
				// 插入到商品分类表中
				$gcModel->add(array(
					'goods_id' => $option['where']['id'],
					'cat_id' => $v,
				));
			}
		}
		// 商品描述有选择性的过滤
		$data['goods_desc'] = clearXSS($_POST['goods_desc']);
		/**** 处理表单中上传的LOGO图片 *****/
		// 判断用户有没有选择图片
		if(isset($_FILES['logo']) && $_FILES['logo']['error'] == 0)
		{
			// 上传图片
			 $upload = new \Think\Upload(array(
			 	'maxSize' => 2 * 1024 * 1024,
			 	'exts' => array('jpg', 'gif', 'png', 'jpeg'),
			 	'rootPath' => './Public/Uploads/',
			 	'savePath' => 'Goods/',
			 ));
		    // 上传文件 
		    $info   =   $upload->upload();
		    if($info)
		    {
		    	/*************** 生成缩略图 ****************/
		    	// 先取出刚刚上传成功的图片的路径和名称
		    	$logo = $info['logo']['savepath'] . $info['logo']['savename'];
		    	// 拼出缩略图的名字
		    	$sm_logo = $info['logo']['savepath'] .'sm_'. $info['logo']['savename'];
		    	$mid_logo = $info['logo']['savepath'] .'mid_'. $info['logo']['savename'];
		    	// 生成缩略图
		    	$image = new \Think\Image(); 
		    	$image->open('./Public/Uploads/'.$logo);
		    	$image->thumb(650, 650)->save('./Public/Uploads/'.$mid_logo);
		    	$image->thumb(130, 130)->save('./Public/Uploads/'.$sm_logo);
		    	// 把生成好的图片的路径放到表单中
		    	$data['logo'] = $logo;
		    	$data['sm_logo'] = $sm_logo;
		    	$data['mid_logo'] = $mid_logo;
		    	/*************** 删除原图片 ******************/
		    	// 取出原图
		    	$oldLogo = $this->field('sm_logo,mid_logo,logo')->find($option['where']['id']);
		    	// 删除原图
		    	@unlink('./Public/Uploads/'.$oldLogo['sm_logo']);
		    	@unlink('./Public/Uploads/'.$oldLogo['mid_logo']);
		    	@unlink('./Public/Uploads/'.$oldLogo['logo']);
		    }
		    else 
		    {
		    	// 先把错误信息保存到模型中，然后返回控制器，由控制器再从模型中取出错误原因并显示
		    	$this->error = $upload->getError();
				return FALSE;
		    }
		}
		/****************************** 处理商品属性 *********************************/
		// 添加新属性
		$attrId = I('post.attr_id');
		$goodsAttr = I('post.goods_attr');
		$gaModel = M('GoodsAttr');
		if($goodsAttr)
		{
			foreach ($goodsAttr as $k => $v)
			{
				$gaModel->add(array(
					'goods_id' => $option['where']['id'],
					'attr_id' => $attrId[$k],
					'attr_value' => $v,
				));
			}
		}
		
		// 修改旧属性
		$gaid = I('post.gaid');
		$oga = I('post.old_goods_attr');
		foreach ($oga as $k => $v)
		{
			$gaModel->where(array(
				'id' => array('eq', $gaid[$k]),
			))->save(array(
				'attr_value' => $v,
			));
		}
		/******************* 处理会员价格 ************************/
		$mp = I('post.member_price');
		$lid = I('post.level_id');
		$mpModel = D('member_price');
		$mpModel->where(array(
			'goods_id' => array('eq', $option['where']['id'])
		))->delete();
		foreach ($mp as $k => $v)
		{
			$_v = (float)$v;
			if($_v > 0)
				$mpModel->add(array(
					'level_id' => $lid[$k],
					'price' => $v,
					'goods_id' => $option['where']['id'],
				));
		}
	}
	/**
	 * 取出当前促销中的商品
	 *
	 * @param unknown_type $limit
	 */
	public function getPromoteGoods($limit = 5)
	{
		$today = date('Y-m-d H:i:s', time());
		return $this->field('id,sm_logo,goods_name,promote_price')->where(array(
			'is_on_sale' => array('eq', '是'),
			'promote_price' => array('neq', 0),
			'promote_start_date' => array('elt', $today),
			'promote_end_date' => array('egt', $today),
		))->limit($limit)->select();
	}
	/**
	 * 获取推荐的商品
	 *
	 * @param unknown_type $type : is_new,is_hot,is_rec
	 * @param unknown_type $limit
	 * @return unknown
	 */
	public function getRecGoods($type, $limit = 5)
	{
		return $this->field('id,sm_logo,goods_name,promote_price')->where(array(
			'is_on_sale' => array('eq', '是'),
			"$type" => array('eq', '是'),
		))->limit($limit)->select();
	}
}














