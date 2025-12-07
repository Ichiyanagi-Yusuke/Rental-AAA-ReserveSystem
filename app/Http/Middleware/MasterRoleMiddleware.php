<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MasterRoleMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        // 未ログイン or role が 0,1 以外なら 403
        if (!$user || !in_array((int)$user->role, [0, 1], true)) {
            abort(403, 'このページにアクセスする権限がありません。');
        }

        return $next($request);
    }
}
