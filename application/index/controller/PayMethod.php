<?php


namespace app\index\controller;

use app\index\model\paymethod\GoodSku as goodskuModel;
use think\Controller;
use think\Db;
use think\facade\Request;
use think\facade\Session;

class PayMethod extends Controller
{
    public function initialize()
    {
        if(!session('customer_name')){
           $this->success('请登陆账号，即将进入登陆页','/login');
        }
    }

    public function payMethod(){
        session('customer_name');
        $out_trade_no=date('Ymd').substr(implode(NULL, array_map('ord', str_split(substr(uniqid(), 7, 13), 1))), 0, 8);
        $list=Db::name('address')->where('customer_name',Session::get('customer_name'))->where('is_default',1)->find();
        $this->assign([
            'address_id'=>$list['address_id'],
            'address_name'=>$list['address_name'],
            'address_phone'=>$list['address_phone'],
            'address_province'=>$list['address_province'],
            'address_city'=>$list['address_city'],
            'address_region'=>$list['address_region'],
            'address_detail'=>$list['address_detail'],
            'out_trade_no'=>$out_trade_no,
        ]);
        return $this->fetch('payMethod');


    }
    public function PayDetail(){
        $good_sku_id=$_POST['good_sku_id'];
        $good=new goodskuModel();
        return json($good->getDetail($good_sku_id));
    }
    public function return_url(){

    }
}