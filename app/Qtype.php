<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Qtype extends Model
{
    /**
     * @var array
     */
    protected $fillable=['name'];


    /**
     * 返回问题类型对应的所有问题
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function questions()
    {
        return $this->hasMany('App\Question');
    }
}
