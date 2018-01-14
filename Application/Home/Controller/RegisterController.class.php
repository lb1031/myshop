<?php
namespace Home\Controller;
use Think\Controller;
class RegisterController extends Controller {

    public function index(){
        $this->display();
    }

    public function send(){
        var_dump($_POST);



    }
}