<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $moduleKey, string $action = 'view'): Response
    {
        // Admin มีทุกสิทธิ์เสมอ
        if (auth()->check() && auth()->user()->isAdmin()) {
            return $next($request);
        }

        // ตรวจสอบ permission
        if (!auth()->check() || !auth()->user()->hasPermission($moduleKey, $action)) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'คุณไม่มีสิทธิ์เข้าถึงหน้านี้',
                    'required_permission' => "{$moduleKey}.{$action}"
                ], 403);
            }

            return redirect()->back()
                ->with('error', "⛔ คุณไม่มีสิทธิ์เข้าถึงหน้านี้ (ต้องการ: {$moduleKey}.{$action})");
        }

        return $next($request);
    }
}
