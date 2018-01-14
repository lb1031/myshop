<?php
namespace Admin\Controller;
use Think\Controller;
class IndexController extends Controller {
    
    //将下面四个方法注释掉还是可以显示页面
    public function index(){

        $this->display();
    }

    public function main(){

        $this->display();
    }

    public function menu(){

        $this->display();
    }

    public function top(){

        $this->display();
    }


}