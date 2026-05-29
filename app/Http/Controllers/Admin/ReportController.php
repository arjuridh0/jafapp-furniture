<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Exports\ProductionReportExport;
use App\Exports\SalesReportExport;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Payment;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ReportController extends Controller
{
    // ─── Sales Report ───────────────────────────────────────────

    public function sales(Request $request): View
    {
        $dateFrom = $request->input('date_from', now()->startOfMonth()->format('Y-m-d'));
        $dateTo = $request->input('date_to', now()->format('Y-m-d'));

        $ordersQuery = Order::whereDate('created_at', '>=', $dateFrom)
            ->whereDate('created_at', '<=', $dateTo)
            ->where('status', '!=', Order::STATUS_CANCELLED);

        $totalOrders = (clone $ordersQuery)->count();
        $totalRevenue = Payment::whereHas('order', fn($q) => $q
            ->whereDate('created_at', '>=', $dateFrom)
            ->whereDate('created_at', '<=', $dateTo)
            ->where('status', '!=', Order::STATUS_CANCELLED))
            ->where('status', 'paid')
            ->sum('amount');

        // Payment method breakdown
        $paymentBreakdown = Payment::whereHas('order', fn($q) => $q
            ->whereDate('created_at', '>=', $dateFrom)
            ->whereDate('created_at', '<=', $dateTo)
            ->where('status', '!=', Order::STATUS_CANCELLED))
            ->where('status', 'paid')
            ->selectRaw('payment_type, COUNT(*) as count, SUM(amount) as total')
            ->groupBy('payment_type')
            ->get();

        $orders = (clone $ordersQuery)->with('payment')->latest()->paginate(20)->withQueryString();

        return view('admin.reports.sales', compact(
            'dateFrom', 'dateTo', 'totalOrders', 'totalRevenue',
            'paymentBreakdown', 'orders'
        ));
    }

    public function exportSalesPdf(Request $request)
    {
        $dateFrom = $request->input('date_from', now()->startOfMonth()->format('Y-m-d'));
        $dateTo = $request->input('date_to', now()->format('Y-m-d'));

        $orders = Order::with('payment')
            ->whereDate('created_at', '>=', $dateFrom)
            ->whereDate('created_at', '<=', $dateTo)
            ->where('status', '!=', Order::STATUS_CANCELLED)
            ->latest()->get();

        $totalRevenue = $orders->sum(fn($o) => $o->payment && $o->payment->isPaid() ? $o->payment->amount : 0);

        $pdf = Pdf::loadView('admin.reports.pdf.sales', compact('orders', 'dateFrom', 'dateTo', 'totalRevenue'));
        $pdf->setPaper('A4', 'landscape');

        return $pdf->download("laporan-penjualan-{$dateFrom}-{$dateTo}.pdf");
    }

    public function exportSalesExcel(Request $request): BinaryFileResponse
    {
        $dateFrom = $request->input('date_from', now()->startOfMonth()->format('Y-m-d'));
        $dateTo = $request->input('date_to', now()->format('Y-m-d'));

        return Excel::download(
            new SalesReportExport($dateFrom, $dateTo),
            "laporan-penjualan-{$dateFrom}-{$dateTo}.xlsx"
        );
    }

    // ─── Production Report ──────────────────────────────────────

    public function production(Request $request): View
    {
        $dateFrom = $request->input('date_from', now()->startOfMonth()->format('Y-m-d'));
        $dateTo = $request->input('date_to', now()->format('Y-m-d'));

        $completedCount = Order::where('status', 'completed')
            ->whereDate('updated_at', '>=', $dateFrom)
            ->whereDate('updated_at', '<=', $dateTo)
            ->count();

        $inProgressCount = Order::whereIn('status', [
            'order_received', 'material_preparation', 'in_production',
            'finishing', 'quality_check', 'ready_to_ship',
        ])->count();

        // Per-stage breakdown (current state)
        $stageBreakdown = Order::whereIn('status', Order::PRODUCTION_STATUS_SEQUENCE)
            ->selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status');

        $orders = Order::with('productionLogs')
            ->whereIn('status', array_merge(Order::PRODUCTION_STATUS_SEQUENCE, ['completed']))
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view('admin.reports.production', compact(
            'dateFrom', 'dateTo', 'completedCount', 'inProgressCount',
            'stageBreakdown', 'orders'
        ));
    }

    public function exportProductionPdf(Request $request)
    {
        $dateFrom = $request->input('date_from', now()->startOfMonth()->format('Y-m-d'));
        $dateTo = $request->input('date_to', now()->format('Y-m-d'));

        $orders = Order::with('productionLogs')
            ->whereIn('status', array_merge(Order::PRODUCTION_STATUS_SEQUENCE, ['completed']))
            ->latest()->get();

        $pdf = Pdf::loadView('admin.reports.pdf.production', compact('orders', 'dateFrom', 'dateTo'));
        $pdf->setPaper('A4', 'landscape');

        return $pdf->download("laporan-produksi-{$dateFrom}-{$dateTo}.pdf");
    }

    public function exportProductionExcel(Request $request): BinaryFileResponse
    {
        $dateFrom = $request->input('date_from', now()->startOfMonth()->format('Y-m-d'));
        $dateTo = $request->input('date_to', now()->format('Y-m-d'));

        return Excel::download(
            new ProductionReportExport($dateFrom, $dateTo),
            "laporan-produksi-{$dateFrom}-{$dateTo}.xlsx"
        );
    }
}
