<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $store = auth()->user()->store;
        if (!$store) {
            return redirect()->route('seller.register')->with('error', 'Toko tidak ditemukan.');
        }
        $startDate = $request->get('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->get('end_date', Carbon::now()->format('Y-m-d'));

        $orderItems = OrderItem::where('store_id', $store->id)
            ->whereHas('order', function ($q) use ($startDate, $endDate) {
                $q->whereBetween('created_at', [$startDate, $endDate . ' 23:59:59'])
                  ->where('status', '!=', Order::STATUS_DIBATALKAN);
            })
            ->with(['order', 'product'])
            ->get();

        $totalRevenue = $orderItems->sum('subtotal');
        $totalOrders = $orderItems->pluck('order_id')->unique()->count();

        return view('seller.reports.index', compact(
            'orderItems', 'totalRevenue', 'totalOrders', 'startDate', 'endDate'
        ));
    }

    public function exportPdf(Request $request)
    {
        $store = auth()->user()->store;
        if (!$store) {
            return redirect()->route('seller.register')->with('error', 'Toko tidak ditemukan.');
        }
        $startDate = $request->get('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->get('end_date', Carbon::now()->format('Y-m-d'));

        $orderItems = OrderItem::where('store_id', $store->id)
            ->whereHas('order', function ($q) use ($startDate, $endDate) {
                $q->whereBetween('created_at', [$startDate, $endDate . ' 23:59:59'])
                  ->where('status', '!=', Order::STATUS_DIBATALKAN);
            })
            ->with(['order', 'product'])
            ->get();

        $totalRevenue = $orderItems->sum('subtotal');

        $storeName = str_replace(' ', '-', strtolower($store->store_name));
        $month = Carbon::parse($startDate)->translatedFormat('F');
        $year = Carbon::parse($startDate)->format('Y');

        $pdf = Pdf::loadView('reports.sales-pdf', compact(
            'store', 'orderItems', 'totalRevenue', 'startDate', 'endDate'
        ))->setPaper('a4', 'portrait');

        return $pdf->download("laporan-{$storeName}-{$month}-{$year}.pdf");
    }
}
