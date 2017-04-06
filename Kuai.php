<?php
// +----------------------------------------------------------------------
// | When work is a pleasure, life is a joy!
// +----------------------------------------------------------------------
// | User: ShouKun Liu  |  Email:24147287@qq.com  | Time:2016/12/20 11:18
// +----------------------------------------------------------------------
// | TITLE: 快递一百
// +----------------------------------------------------------------------


class Kuai 
{
    public static $AppKey = 'kSeAYNOO2314';
    public static $customer = '408F5D388580E1B72107B6233BF58F37';

    public function getExpressList()
    {

    }

    public function getExpressInfo($number, $com)
    {
        $arr['com'] = $com;//self::_code_to_code($com) ;
        $arr['num'] = $number;

        $post_data = array();
        $post_data["customer"] = self::$customer;
        $key = self::$AppKey;
        $post_data["param"] = json_encode($arr);
        $url = 'http://poll.kuaidi100.com/poll/query.do';
        $post_data["sign"] = md5($post_data["param"] . $key . $post_data["customer"]);
        $post_data["sign"] = strtoupper($post_data["sign"]);
        $o = "";
        foreach ($post_data as $k => $v) {
            $o .= "$k=" . urlencode($v) . "&";        //默认UTF-8编码格式
        }
        $post_data = substr($o, 0, -1);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        $result = curl_exec($ch);

        $data = str_replace("\"", '"', $result);
        $data = json_decode($data, true);
        if (isset( $data['result'] ) && $data['result']==false ) return false;
        return $data;
    }

    protected static function _code_to_code($code)
    {
        $codeList = array(
            'SFEXPRESS' => 'shunfeng',
            'EMS' => 'ems',
            'STO' => 'shengtong',
            'YTO' => 'yuantong',
            'ZTO' => 'zhongtong ',
            'ZJS' => 'zjs',
            'YUNDA' => 'yunda',
            'HTKY' => 'huitongkuaidi',
            'CHINAPOST' => 'youzhengguonei',
            'BROADASIA' => 'air',
            'DTW' => 'datianwuliu ',
            'QFKD' => 'qfkd',
            'UC56' => 'uc',
            'TTKDEX' => 'tiantian',
            'DEPPON' => 'debangwuliu',
            'JD' => 'jdkd',
        );
        if (empty($codeList[$code])) {
            $returnCode = strtoupper($code);
        } else {
            $returnCode = $codeList[$code];
        }

        return $returnCode;


    }

}

$kuai = new Kuai();
$arr = $kuai->getExpressInfo('422316561160','zhongtong');
var_dump($arr);
