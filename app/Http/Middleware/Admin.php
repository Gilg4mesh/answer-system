<?php

namespace App\Http\Middleware;

use Closure;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //如果当前登录为管理员账户(id=1)，可以访问，否则没有此权限
        if($request->user()->id===1)
            return $next($request);

        flash()->error("LIMITED AUTHORITY!");
        return redirect('/');
    }
}
