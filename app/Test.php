<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Question;


class Test extends Model
{
    //

    protected $guarded = ['id'];

    /**
     * 获取该测试的用户
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * 返回一张试卷对应的题目
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function questions()
    {
        return $this->belongsToMany('App\Question')->withTimestamps();
    }

    /**
     * 根据不同方式生成题目的id
     * @param int $tagList : 按照tag选择题目范围
     * @param int $testType :生成方式，0表示随机，1表示顺序
     * @param int $totalNumber ：题目数目,0默认为全部
     * @return array|mixed
     */
    public static function generateQuestion($tagList = 0, $testType = 0, $totalNumber = 5)
    {

        if ($tagList == 1)//$taglist为1默认选择范围不限，获取所有的问题
            $question_all = Question::pluck('id', 'id')->toArray();
        else {
            $tag=Tag::find($tagList);//否则获取当前的tag
            $question_all=$tag->questions->pluck('id','id')->toArray();//获取当前的所有问题
        }


        if($totalNumber==0||$totalNumber>count($question_all))
            $totalNumber=count($question_all);  //题量不能超过所有的限制，0时意味着取全部
        switch ($testType) {
            case 0:     //0表示随机生成，array_rand函数只能对key随机
                $question_ids = array_rand($question_all, $totalNumber);
                break;
            case 1:
                $question_ids = array_slice($question_all, 0, $totalNumber);//顺序生成的话只需要截取前面的部分即可。
                break;
            default://其余暂且默认为是随机形式
                $question_ids = array_rand($question_all, $totalNumber);
                break;
        }
        $key = range(1, $totalNumber);
        return array_combine($key, (array)$question_ids);//返回键值从1开始的关联数组

    }
}
