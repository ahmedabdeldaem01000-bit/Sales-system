<?php

namespace App\Http\Controllers;

 
use App\Models\InstallmentItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use DB;
use Illuminate\Http\Request;
use Carbon\Carbon;

class home extends Controller
{
    public function index(){
        // ====== CHART DATA: Monthly Orders ======
$results = Order::select(
            DB::raw('COUNT(id) as total'), 
            DB::raw("DATE_FORMAT(created_at, '%M') as month_name"), // بيطلع اسم الشهر (January, February...)
            DB::raw('MAX(created_at) as sort_date')
        )
        ->whereYear('created_at', date('Y')) // بيجيب بيانات السنة الحالية بس
        ->groupBy('month_name')
        ->orderBy('sort_date', 'ASC')
        ->get();

    $labels = $results->pluck('month_name');
    $values = $results->pluck('total');
   $monthsArabic = [
    'January' => 'يناير', 'February' => 'فبراير', 'March' => 'مارس',
    'April' => 'أبريل', 'May' => 'مايو', 'June' => 'يونيو',
    'July' => 'يوليو', 'August' => 'أغسطس', 'September' => 'سبتمبر',
    'October' => 'أكتوبر', 'November' => 'نوفمبر', 'December' => 'ديسمبر'
];

$labels = $results->pluck('month_name')->map(function($month) use ($monthsArabic) {
    return $monthsArabic[$month] ?? $month;
});


$monthlyOrdersRaw = Order::selectRaw("
    MONTH(created_at) as month,
    COUNT(*) as count,
    SUM(total) as revenue
")
->whereYear('created_at', now()->year)
->groupByRaw("MONTH(created_at)")
->orderByRaw("MONTH(created_at)")
->get();

$months = [];
$counts = [];
$revenues = [];

foreach (range(1, 12) as $m) {
    $monthData = $monthlyOrdersRaw->firstWhere('month', $m);
    $months[] = \Carbon\Carbon::create()->month($m)->format('M');
    $counts[] = $monthData->count ?? 0;
    $revenues[] = $monthData->revenue ?? 0;
}

        // ====== TOP SELLING PRODUCTS ======
        $topProducts = OrderItem::selectRaw('product_id, COUNT(*) as order_count, SUM(quantity) as total_quantity')
            ->with('product')
            ->groupBy('product_id')
            ->orderByDesc('order_count')
            ->limit(5)
            ->get();

        // ====== USERS WITH ORDERS ======
        $usersWithOrders = Order::selectRaw('user_id, users.name, users.email, COUNT(orders.id) as total_orders, SUM(orders.total) as total_spent')
            ->join('users', 'orders.user_id', '=', 'users.id')
            ->groupBy('user_id', 'users.name', 'users.email')
            ->orderByDesc('total_spent')
            ->limit(5)
            ->get();

        // ====== SUMMARY STATS ======
        $totalUnpaid = InstallmentItem::where('status', 'pending')->sum(DB::raw('amount'));
        $salesCount = Order::count();
        $customersCount = User::whereHas('order')->distinct()->count();
        $totalRevenue = Order::sum('total');
//  dd($totalUnpaid);
        return view('home', [
 'totalUnpaid' => $totalUnpaid,
    'salesCount' => $salesCount,
    'customersCount' => $customersCount,
    'totalRevenue' => $totalRevenue,
    'topProducts' => $topProducts,
    'usersWithOrders' => $usersWithOrders,
    'months' => $months,    // مصفوفة أسماء الشهور
    'counts' => $counts,    // مصفوفة أعداد الطلبات
    'revenues' => $revenues,
    'labels' => $labels,
    'values' => $values
        ]);
    }
}
