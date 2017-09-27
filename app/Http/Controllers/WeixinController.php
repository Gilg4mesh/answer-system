<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class WeixinController extends Controller
{
    //
    public function __construct()
    {
        $this->beforeFilter('weixin', array('on' => 'get|post'));
    }

    public function index(Request $request)
    {
        /*$postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
        if (!empty($postStr)){
            $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
            $RX_TYPE = trim($postObj->MsgType);
            $result=$RX_TYPE;
            echo $result;
            //   $this->test($RX_TYPE) ;
            /*switch ($RX_TYPE)
            {
                case "text":
                    $resultStr = $this->receiveText($postObj);
                    break;
                case "image":
                    $resultStr = $this->receiveImage($postObj);
                    break ;
                case "voice":
                    $resultStr = $this->receiveVoice($postObj) ;
                    break ;
                case "event":
                    $resultStr = $this->receiveEvent($postObj);
                    break;
                default:
                    $resultStr = "unknow msg type: ".$RX_TYPE;
                    break;
            }
            echo $resultStr;

            }
            else {
            echo "";
            exit;
        }
    */
        return Input::get('echostr');

    }
}
