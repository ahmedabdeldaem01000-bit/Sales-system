<?php

namespace App\Providers;

use App\Http\Middleware\CheckRole;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    public const HOME = '/dashboard'; // ← عدل دا حسب المسار اللي عاوزه بعد تسجيل الدخول

    public function boot(): void
{
    Route::aliasMiddleware('check.role', CheckRole::class); // ✅ سجل اسم الميدل وير

    // ✅ راوتات الأدمن
    Route::middleware(['web', 'auth', 'check.role:admin'])
        ->group(base_path('routes/admin.php'));

    // ✅ راوتات الموظف
    Route::middleware(['web', 'auth', 'check.role:employee'])
        ->group(base_path('routes/employee.php'));
}
}
