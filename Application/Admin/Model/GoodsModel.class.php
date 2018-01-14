<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/13
 * Time: 11:50
 */

namespace Admin\Model;


use Think\Model;

class GoodsModel extends Model
{
    //设置表单提交只允许有哪些字段，避免表单被模拟
    protected $insertFileds = 'goods_name,market_price,shop_price,is_on_sale,goods_desc';

    protected $_validate = array(
        array('goods_name','require','商品名称不能为空！',1),
        array('market_price','currency','市场价格必须是货币类型！',1),
        array('shop_price','currency','本店价格必须是货币类型！',1),

    );

    protected function _before_insert(&$data,$option){

        //添加纪录时间
        $data['addtime'] = time();

        /**************************处理表单上传的LOGO图片***********************/

        if(isset($_FILES['logo']) &&  $_FILES['logo']['error'] == 0){
            $upload = new \Think\Upload(array(
                'maxSize'=>2*1024*1024,
                'exts'=>array('jpg','gif','png','jpeg'),
                'rootPath'=>'./Public/Uploads/',
                'savePath'=>'Goods/',
            ));

            //上传文件
            $info = $upload->upload();

            if($info){
                //取出上传图片的名字和路径
                $logo = $info['logo']['savepath'].$info['logo']['savename'];

                //拼出缩略图的名字 也就是图片的保存路径和图片的名字
                $sm_logo = $info['logo']['savepath'].'sm_'.$info['logo']['savename'];
                $mid_logo = $info['logo']['savepath'].'mid_'.$info['logo']['savename'];
            //生成缩略图
                $image = new \Think\Image();
                $image->open('./Public/Uploads/'.$logo);
                $image->thumb(650,650)->save('./Public/Uploads/'.$sm_logo);
                $image->thumb(130,130)->save('./Public/Uploads/'.$mid_logo);

                //把生成好的的图片路径放入数据中以便存库

                $data['logo'] = $logo;
                $data['sm_logo'] = $sm_logo;
                $data['mid_logo'] = $mid_logo;


            }else{

                //把错误信息保存到模型中，返回给控制器，由控制器从模型中取出错误信息并输出
                $this->error = $upload->getError();
                return  false;
            }


        }


    }

    public function  search(){

        $where = array();
        if($gn = I('get.gn')){
            $where['goods_name'] = array('like',"%$gn%");
        }

        $gf = I('get.fg');
        $gt = I('get.tg');

        if($gf && $gt){
            $where['shop_price'] = array('between',array("$gf","$gt"));
        }else if($gf){
            $where['shop_price'] = array('egt',$gf);
        }else if($gt){
            $where['shop_price'] = array('elt',$gt);
        }

        $is_sale = I('get.is_on_sale');
        if($is_sale){
            $where['is_on_sale'] = array('eq',$is_sale);
        }

        /****************************设置分页*********************/

        $count      = $this->where($where)->count();// 查询满足要求的总记录数
        $page       = new \Think\Page($count,2);// 实例化分页类 传入总记录数和每页显示的记录数(25)
        $show       = $page->show();// 分页显示输出


        $data = $this->where($where)->limit($page->firstRow.','.$page->listRows)->select();
        return array(
            'data'=>$data,
            'show'=>$show
        );

    }

    protected function _before_update(&$data,$option){

        //添加纪录时间
        $data['addtime'] = time();

        /**************************处理表单上传的LOGO图片***********************/

        if(isset($_FILES['logo']) &&  $_FILES['logo']['error'] == 0){
            $upload = new \Think\Upload(array(
                'maxSize'=>2*1024*1024,
                'exts'=>array('jpg','gif','png','jpeg'),
                'rootPath'=>'./Public/Uploads/',
                'savePath'=>'Goods/',
            ));

            //上传文件
            $info = $upload->upload();

            if($info){
                //取出上传图片的名字和路径
                $logo = $info['logo']['savepath'].$info['logo']['savename'];

                //拼出缩略图的名字 也就是图片的保存路径和图片的名字
                $sm_logo = $info['logo']['savepath'].'sm_'.$info['logo']['savename'];
                $mid_logo = $info['logo']['savepath'].'mid_'.$info['logo']['savename'];
                //生成缩略图
                $image = new \Think\Image();
                $image->open('./Public/Uploads/'.$logo);
                $image->thumb(650,650)->save('./Public/Uploads/'.$sm_logo);
                $image->thumb(130,130)->save('./Public/Uploads/'.$mid_logo);

                //把生成好的的图片路径放入数据中以便存库

                $data['logo'] = $logo;
                $data['sm_logo'] = $sm_logo;
                $data['mid_logo'] = $mid_logo;

                /*************************删除原图***************************/

                $oldimg = $this->field('logo,sm_logo,mid_logo')->find($option['where']['id']);
                @unlink('./Public/Uploads/'.$oldimg['logo']);
                @unlink('./Public/Uploads/'.$oldimg['sm_logo']);
                @unlink('./Public/Uploads/'.$oldimg['mid_logo']);


            }else{

                //把错误信息保存到模型中，返回给控制器，由控制器从模型中取出错误信息并输出
                $this->error = $upload->getError();
                return  false;
            }

        }

    }

    public function _before_delete($option){

        /**************************删除图片**************/
        $oldimg = $this->field('logo,sm_logo,mid_logo')->find($option['where']['id']);

        @unlink('./Public/Uploads/'.$oldimg['logo']);
        @unlink('./Public/Uploads/'.$oldimg['sm_logo']);
        @unlink('./Public/Uploads/'.$oldimg['mid_logo']);
    }
}