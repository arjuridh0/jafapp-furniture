<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CustomOrder;
use App\Models\Order;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        // ─── KPI Cards ──────────────────────────────────────────────
        $todayOrders = Order::whereDate('created_at', today())->count();

        $monthRevenue = Payment::where('status', 'paid')
            ->whereMonth('paid_at', now()->month)
            ->whereYear('paid_at', now()->year)
            ->sum('amount');

        $pendingOrders = Order::where('status', Order::STATUS_PENDING_PAYMENT)->count();

        $activeProduction = Order::whereIn('status', [
            Order::STATUS_ORDER_RECEIVED,
            Order::STATUS_MATERIAL_PREPARATION,
            Order::STATUS_IN_PRODUCTION,
            Order::STATUS_FINISHING,
            Order::STATUS_QUALITY_CHECK,
            Order::STATUS_READY_TO_SHIP,
        ])->count();

        // ─── Recent Orders Table ────────────────────────────────────
        $ordersQuery = Order::with(['user', 'payment'])->latest();

        if ($request->filled('status')) {
            $ordersQuery->where('status', $request->status);
        }

        if ($request->filled('date_from')) {
            $ordersQuery->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $ordersQuery->whereDate('created_at', '<=', $request->date_to);
        }

        $orders = $ordersQuery->paginate(15)->withQueryString();

        // ─── Chart Data (30 days) ───────────────────────────────────
        $chartData = Order::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->where('created_at', '>=', now()->subDays(30))
            ->groupByRaw('DATE(created_at)')
            ->orderBy('date')
            ->pluck('count', 'date')
            ->toArray();

        // Fill in missing days
        $chart = [];
        for ($i = 29; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $chart[$date] = $chartData[$date] ?? 0;
        }

        // ─── Super Admin Extra Data ─────────────────────────────────
        $superAdminData = null;
        if (auth()->user()->isSuperAdmin()) {
            // Revenue chart (30 days)
            $revenueData = Payment::where('status', 'paid')
                ->where('paid_at', '>=', now()->subDays(30))
                ->selectRaw('DATE(paid_at) as date, SUM(amount) as total')
                ->groupByRaw('DATE(paid_at)')
                ->orderBy('date')
                ->pluck('total', 'date')
                ->toArray();

            $revenueChart = [];
            for ($i = 29; $i >= 0; $i--) {
                $date = now()->subDays($i)->format('Y-m-d');
                $revenueChart[$date] = (float) ($revenueData[$date] ?? 0);
            }

            // User stats
            $totalUsers = User::count();
            $totalCustomers = User::where('role', 'customer')->count();
            $totalAdmins = User::whereIn('role', ['admin', 'superadmin'])->count();
            $newUsersThisMonth = User::whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->count();

            // Custom order stats
            $pendingCustomOrders = CustomOrder::where('status', 'submitted')->count();
            $totalCustomOrders = CustomOrder::count();

            // Order status distribution for pie chart
            $statusDistribution = Order::selectRaw("
                CASE
                    WHEN status = 'pending_payment' THEN 'Menunggu Bayar'
                    WHEN status = 'payment_confirmed' THEN 'Dibayar'
                    WHEN status IN ('order_received','material_preparation','in_production','finishing','quality_check','ready_to_ship') THEN 'Produksi'
                    WHEN status = 'completed' THEN 'Selesai'
                    WHEN status = 'cancelled' THEN 'Batal'
                    ELSE 'Lainnya'
                END as group_label,
                COUNT(*) as count
            ")
            ->groupByRaw("group_label")
            ->pluck('count', 'group_label')
            ->toArray();

            $superAdminData = compact(
                'revenueChart',
                'totalUsers',
                'totalCustomers',
                'totalAdmins',
                'newUsersThisMonth',
                'pendingCustomOrders',
                'totalCustomOrders',
                'statusDistribution',
            );
        }

        return view('admin.dashboard.index', compact(
            'todayOrders',
            'monthRevenue',
            'pendingOrders',
            'activeProduction',
            'orders',
            'chart',
            'superAdminData',
        ));
    }
}
