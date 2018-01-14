<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/13
 * Time: 14:27
 */

namespace Admin\Controller;


use Think\Controller;

class GoodsController extends Controller
{

    public function add(){

        //判断表单是否提交
        if(IS_POST){

//            var_dump($_POST);die;
            //生成商品模型
            $model = D('Goods');
            //接受表单数据并用模型定义的方法进行验证

            if($model->create(I('post.'),1)){

                if($model->add()){
                    //提示成功，并跳转到list方法中
                    $this->success('添加成功',U('lst'));
                    exit;
                }
            }

            $error = $model->getError();
            $this->error($error);
        }
        //设置页面信息
        $this->assign(array(
            '_page_title'=>'添加商品',
            '_page_btn_link'=>U('lst'),
            '_page_btn_name'=>'商品列表'
        ));

        //显示表单
        $this->display();
    }



    public function lst(){

        $model = D('goods');
        $data = $model->search();
        $this->assign('data',$data['data']);
        $this->assign('show',$data['show']);

        //设置页面信息
        $this->assign(array(
            '_page_title'=>'商品列表',
            '_page_btn_link'=>U('add'),
            '_page_btn_name'=>'添加商品'
        ));
        $this->display();

    }

    public function edit(){

        $id = I('get.id');
        //判断表单是否提交
        if(IS_POST){

            //生成商品模型
            $model = D('Goods');
            //接受表单数据并用模型定义的方法进行验证
            if($model->create(I('post.'),2)){

                if(FALSE !== $model->save()){
                    //提示成功，并跳转到list方法中
                    $this->success('修改成功',U('lst'));
                    exit;
                }
            }
            $error = $model->getError();
            $this->error($error);

        }
        //显示表单

        $model = M('goods');
        $info = $model->find($id);
        $this->assign('info',$info);

        //设置页面信息
        $this->assign(array(
            '_page_title'=>'商品修改',
            '_page_btn_link'=>U('lst'),
            '_page_btn_name'=>'添加列表'
        ));

        $this->display();

    }

    public function delete(){
        $id = I('get.id');

        $model = D('goods');
        if($model->delete($id) !== FALSE){
            $this->success('删除成功');
            exit;
        }
        $this->error('删除失败');



    }

}