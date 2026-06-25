<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Store;
use App\Models\User;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_users' => User::count(),
            'total_stores' => Store::count(),
            'total_orders' => Order::where('status', '!=', Order::STATUS_DIBATALKAN)->count(),
            'gmv' => Order::where('status', '!=', Order::STATUS_DIBATALKAN)->sum('total_amount'),
        ];

        $recentOrders = Order::with(['buyer', 'items.store'])
            ->latest()
            ->take(10)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentOrders'));
    }

    public function exportPdf()
    {
        $stats = [
            'total_users' => User::count(),
            'total_stores' => Store::count(),
            'total_orders' => Order::where('status', '!=', Order::STATUS_DIBATALKAN)->count(),
            'gmv' => Order::where('status', '!=', Order::STATUS_DIBATALKAN)->sum('total_amount'),
        ];

        $recentOrders = Order::with(['buyer', 'items.store'])
            ->where('status', '!=', Order::STATUS_DIBATALKAN)
            ->latest()
            ->take(50)
            ->get();

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('reports.admin-pdf', compact('stats', 'recentOrders'))
            ->setPaper('a4', 'portrait');

        return $pdf->download("laporan-global-aksaraloka-" . date('F-Y') . ".pdf");
    }
}
