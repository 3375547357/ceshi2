<?php
namespace app\index\controller;
use think\Db;
use think\User;
use think\Validate;
use think\Controller;
class Pay extends Controller
{
    public function pay_order()
        {
            $res = new OrderGoods();
            //获取订单号
            $where['id'] = input('post.order_sn');
            $reoderSn = input('post.order_sn');
            //查询订单信息
            $order_info = $res->where($where)->find();
            //获取支付方式
            $pay_type = input('post.pay_type');//微信支付 或者支付宝支付
            //获取支付金额
            $money = input('post.totle_sum');
            //判断支付方式
            switch ($pay_type) {
                case 'ali';//如果支付方式为支付宝支付
     
                    break;
                case 'wx';
                    $type['pay_type'] = 'wx';//更新支付方式为微信
                    $res->where($where)->update($type);
     
                    $wx = new Wxpay();//实例化微信支付控制器
     
                    $body = '订单号' . $order_info;//支付说明
     
                    $out_trade_no = $reoderSn;//订单号
     
                    $total_fee = $money * 100;//支付金额(乘以100)
     
                    $notify_url = '';//回调地址
     
                    $order = $wx->getPrePayOrder($body, $out_trade_no, $total_fee, $notify_url);//调用微信支付的方法
     
                    if ($order['prepay_id']){//判断返回参数中是否有prepay_id
     
                        $order1 = $wx->getOrder($order['prepay_id']);//执行二次签名返回参数
     
                        echo json_encode(array('status' => 1, 'prepay_order' => no_null($order1)));
                    } else {
                        echo json_encode(array('status' => 0, 'msg' => $order['err_code_des']));
                    }
                    break;
            }
        }
}
