<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function salesReports()
    {
        return view('admin.reports.sales');
    }

    public function getSalesData(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date'
        ]);

        // Convert dates to Carbon instances and adjust for full day coverage
        $startDate = Carbon::parse($request->start_date)->startOfDay();
        $endDate = Carbon::parse($request->end_date)->endOfDay();

        // Bar chart data - daily sales
        $dailySales = Order::select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(total_amount) as total')
            )
            ->whereBetween('created_at', [$startDate, $endDate])
            ->where('status', 'completed')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Pie chart data - product sales
        $productSales = OrderItem::select(
                'products.name as product_name',
                DB::raw('SUM(order_items.quantity * order_items.price) as total_sales')
            )
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->whereBetween('orders.created_at', [$startDate, $endDate])
            ->where('orders.status', 'completed')
            ->groupBy('product_name')
            ->orderByDesc('total_sales')
            ->get();

        return response()->json([
            'dailySales' => $dailySales,
            'productSales' => $productSales
        ]);
    }
}