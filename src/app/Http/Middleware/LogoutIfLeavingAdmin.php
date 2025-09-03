<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogoutIfLeavingAdmin
{
    public function handle(Request $request, Closure $next)
    {
        // 管理画面配下以外にアクセスしたらログアウト（静的アセットは除外）
        if (Auth::check()) {
            $isAdmin = $request->is('admin') || $request->is('admin/*');
            $isAsset = $request->is('css/*') || $request->is('js/*') || $request->is('images/*') || $request->is('storage/*');

            if (! $isAdmin && ! $isAsset) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
            }
        }

        return $next($request);
    }
}


