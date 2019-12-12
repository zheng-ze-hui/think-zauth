<?php

namespace zauth\middleware;

use think\Request;

class Za
{
    /**
     * Undocumented function.
     *
     * @param Request  $request
     * @param \Closure $next
     * @param mixed    ...$args
     *
     * @return mixed
     */
    public function handle(Request $request, \Closure $next, $args)
    {


        return $next($request);
    }

}
