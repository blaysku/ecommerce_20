<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Suggest;
use Carbon\Carbon;
use DB;

class DashboardController extends Controller
{
    public function index()
    {
        $counts = [
            'users' => DB::table('users')->where('created_at', '>=', Carbon::today())->count(),
            'orders' => DB::table('orders')->where('created_at', '>=', Carbon::today())->count(),
            'products' => DB::table('products')->count(),
            'categories' => DB::table('categories')->where('parent_id', '!=', config('setting.rootcategory'))->count(),
        ];

        $suggests = Suggest::select('id', 'name', 'category_id')->latest()->take(10)->get();
        $orders = Order::select('id', 'created_at', 'total_price')->latest()->take(10)->get();

        return view('admin.dashboard', compact('counts', 'suggests', 'orders'));
    }

    public function getStatisticsData(Request $request)
    {
        $days = $request->get('days', config('setting.default_day_stats'));
        $range = Carbon::now()->subDays($days);
        $stats = Order::where('created_at', '>=', $range)
            ->groupBy('date')
            ->orderBy('date', 'ASC')
            ->get([
                DB::raw('Date(created_at) as date'),
                DB::raw('COUNT(*) as value'),
            ]);

        return $stats;
    }
}
