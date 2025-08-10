<?php

class Home extends controller
{
    public function index()
    {
        $model = new Model;
        $arr['id'] = '001';
        $arr1['name'] = 'dilana';
        $result =$model->delete($arr,$arr1);
        echo "this is home controller";
        $this->view('home');
    }
}

