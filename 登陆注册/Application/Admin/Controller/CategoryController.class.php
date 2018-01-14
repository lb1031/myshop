<?php
namespace Admin\Controller;
class CategoryController extends BaseController 
{
	// 删除
	public function delete()
	{
		$id = I('get.id');
		$model = D('Category');
		if(FALSE !== $model->delete($id))
		{
			$this->success('删除成功！'); // 返回上一页面
			exit;
		}
		else 
			$this->error('删除失败！');
	}
	// 列表页 -> 树形结构
	public function lst()
	{
		$model = D('Category');
		$data = $model->getTree();
		$this->assign('data', $data);
		// 设置页面的信息
		$this->assign(array(
			'_page_title' => '分类列表',
			'_page_btn_name' => '添加分类',
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
			$model = D('Category');
			if($model->create(I('post.'), 2))
			{
				if(FALSE !== $model->save())
				{
					$this->success('修改成功！', U('lst'));
					exit;
				}
			}
			$error = $model->getError();
			$this->error($error);
		}
		// 取出要修改的商品信息
		$model = D('Category');
		$info = $model->find($id);
		// 取出所有的分类
		$data = $model->getTree();
		// 取出当前分类的所有子分类的ID，然后在表单中的下接环框中不显示这些分类
		$children = $model->getChildren($id);
		
		$this->assign('children', $children);
		$this->assign('info', $info);
		$this->assign('data', $data);
		
		// 设置页面的信息
		$this->assign(array(
			'_page_title' => '分类修改',
			'_page_btn_name' => '分类列表',
			'_page_btn_link' => U('lst'),
		));
		// 1. 显示表单
		$this->display();
	}
	// 添加
	public function add()
	{
		if(IS_POST)
		{
			$model = D('Category');
			if($model->create(I('post.'), 1))
			{
				if($model->add())
				{
					$this->success('添加成功！', U('lst'));
					exit;
				}
			}
			$error = $model->getError();
			$this->error($error);
		}
		// 取出所有的分类
		$catModel = D('Category');
		$data = $catModel->getTree();
		// 设置页面的信息
		$this->assign(array(
			'data' => $data,
			'_page_title' => '分类添加',
			'_page_btn_name' => '分类列表',
			'_page_btn_link' => U('lst'),
		));
		// 1. 显示表单
		$this->display();
	}
}