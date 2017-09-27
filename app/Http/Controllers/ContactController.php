<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use App\Comment;

class ContactController extends Controller
{
    /**
     * 中文分词接口id
     *
     * @var string
     */
    private $appid = "29982";

    /**
     * 中文分词接口
     *
     * @var string
     */
    private $secret = '1abd713e1e074391a27e3f6a0a58f7fb';

    /**
     * 建立的关键词与参考文档网址对应表（不全）
     *
     * @var array
     */
    private $map = [
        "http://doc.phpleague.cn/lm/view?chr=Web_Page&child=Jquery" => ['jquery','ajax'],
        "http://doc.phpleague.cn/lm/view?chr=Web_Page&child=html_CheatSheet" => ['html','table', 'form', '表单', '表格'],
        "http://doc.phpleague.cn/lm/view?chr=phpStudy&child=Chapter1"=>['基础知识','print','var_dump','print_f','print','echo','include','require','include_once','require_once'],
        "http://doc.phpleague.cn/lm/view?chr=phpStudy&child=Chapter2"=>['语言基础','常量','变量','局部变量','内存管理','$_GLOBALS','$_SERVER','$_GET','$_POST','$_FILES','$_COOKIE','$_SESSION','$_REQUEST','$_ENV'],
        "http://doc.phpleague.cn/lm/view?chr=phpStudy&child=Chapter3"=>['流程控制','if','else','foreach','for','while','break','continue'],
        "http://doc.phpleague.cn/lm/view?chr=phpStudy&child=Chapter4"=>['函数','参数','引用传递','返回值','匿名函数','闭包'],
        "http://doc.phpleague.cn/lm/view?chr=phpStudy&child=Chpater5" => ['数组', 'array','key','current','each','reset','next','prev','range','compact','extract','explode','implode'],
        "http://doc.phpleague.cn/lm/view?chr=phpStudy&child=Chapter6" => ['字符串', '字符', 'string','char','str','word','strpos',],
        "http://doc.phpleague.cn/lm/view?chr=phpStudy&child=Chapter7"=>['正则表达式','regexp','定界符','匹配','贪婪匹配','捕获组','反向引用','pcre','preg'],
        "http://doc.phpleague.cn/lm/view?chr=phpStudy&child=Chapter8"=>['时间与日期','时间戳','unix','date','time'],
        "http://doc.phpleague.cn/lm/view?chr=phpStudy&child=Chapter9"=>['文件与目录','file','fopen','fgets','fwrite','readfile','fpassthru','fwrite','fclose','is_dir','unlink','copy','rename'],
        "http://doc.phpleague.cn/lm/view?chr=phpStudy&child=Chapter10"=>['面向对象','类','接口','trait','class','interface','static','public','private','继承'],

        "http://doc.phpleague.cn/lm/view?chr=phpStudy&child=Chapter11"=>['表单','get','post','按钮','文本框','密码框','隐藏框','文本域','下拉列表','头信息'],
        "http://doc.phpleague.cn/lm/view?chr=phpStudy&child=Chapter13"=>['异常与错误','异常','错误','try','catch','exception','error'],
        "http://doc.phpleague.cn/lm/view?chr=phpStudy&child=Chapter14"=>['PSR','命名空间','namespace','自动加载','代码规范']
    ];

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('contact.index');
    }

    /**
     * 接收发送的信息，返回传递的字符串
     *
     * @param Request $request
     * @return mixed
     */
    public function message(Request $request)
    {
        $command = trim($request->input('command'));
        $status = $request->input('ss');

        switch ($status) {
            case 0:
                $result = $this->root($command);
                break;
            case 1:
                $result = $this->comment($command);
                break;
            case 2:
                $result = $this->question($command);
                break;
            default:
                $result = $this->root($command);
                break;
        }
        return response()->json($result, 200);
    }


    /**
     * 当在根目录时的响应和状态
     * @param $command
     * @return array
     */
    private function root($command)
    {
        switch ($command) {
            case "1":
                $receive = "您的每一份意见，都是我前进的动力！<br />请输入您的意见<br/>输入0返回上一层";
                $ss = 1;
                break;
            case 2:
                $receive = "请输入您的问题<br />输入0返回上一层";
                $ss = 2;
                break;
            default:
                $receive = "请输入指定数字！";
                $ss = 0;
                break;
        }
        return compact('receive', 'ss');

    }


    /**
     * 当处于发表意见时的操作：存储意见到数据库中，并且做出回应
     * @param $comment
     * @return array
     */
    private function comment($comment)
    {

        $user_id = Auth::user()->id;
        switch ($comment) {
            case "0":
                $receive = " 请输入对应数字，进入以下选项：<br/>1:发表意见<br/>2:题目答疑<br/>";
                $ss = 0;
                break;
            default:

                Comment::create(compact('user_id', 'comment'));
                $receive = "感谢您宝贵的意见！";
                $ss = 1;
                break;
        }
        return compact('receive', 'ss');

    }


    /**
     * 在提问状态时的操作，分解词汇返回对应的文档网址
     *
     * @param $command
     * @return array
     */
    private function question($command)
    {

        switch ($command) {
            case "0":
                $receive = " 输入对应数字，进入以下选项：<br/>1:发表意见<br/>2:题目答疑<br/>";
                $ss = 0;
                break;
            default:
                $receive = $this->wordAnalyse($command);
                $ss = 2;
                break;
        }
        return compact('receive', 'ss');
    }


    /**
     * 对词义进行分析返回要显示的内容
     *
     * @param $command
     */
    private function wordAnalyse($command)
    {
        //对词义的分解和分析，最好分开
        $paramArr = array(
            'showapi_appid' => $this->appid,
            'precise' => "0.5",
            'debug' => "0",
            'text' => $command
            //添加其他参数
        );
        $param = $this->createParam($paramArr, $this->secret);
        $url = 'http://route.showapi.com/269-1?' . $param;
        $result = file_get_contents($url);
        $result = json_decode($result);
        if ($result->showapi_res_code != 0) {//解析词失败
            $receive = "Sorry! I cannot understand";
        } else {
            $lists = $result->showapi_res_body->list;//解析出分词后的结果。

            $map = $this->map;//获取映射表
            $receive = '';
            foreach ($map as $key => $values) {
                if (count(array_intersect($values, $lists)) != 0)
                    $receive .= "想要了解更多$values[0]的内容，<a href=$key>请点击此处</a>";
            }
            if (strlen($receive) == 0)
                $receive = "Sorry, I don't understand!";
        }
        return $receive;
    }


    /**
     * 词汇分解词义的分析中创建参数的操作
     * @param $paramArr
     * @param $showapi_secret
     * @return string
     */
    private function createParam($paramArr, $showapi_secret)
    {
        $paraStr = "";
        $signStr = "";
        ksort($paramArr);
        foreach ($paramArr as $key => $val) {
            if ($key != '' && $val != '') {
                $signStr .= $key . $val;
                $paraStr .= $key . '=' . urlencode($val) . '&';
            }
        }
        $signStr .= $showapi_secret;//排好序的参数加上secret,进行md5
        $sign = strtolower(md5($signStr));
        $paraStr .= 'showapi_sign=' . $sign;//将md5后的值作为参数,便于服务器的效验
        return $paraStr;
    }
}
