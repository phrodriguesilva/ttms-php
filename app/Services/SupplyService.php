<?php

namespace App\Services;

use App\Models\Supply;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SupplyService
{
    /**
     * Check for supplies with low stock and return alerts
     */
    public function checkLowStock(): Collection
    {
        return Supply::where('stock_quantity', '<=', DB::raw('minimum_stock'))
            ->get()
            ->map(function ($supply) {
                return [
                    'id' => $supply->id,
                    'name' => $supply->name,
                    'sku' => $supply->sku,
                    'current_stock' => $supply->stock_quantity,
                    'minimum_stock' => $supply->minimum_stock,
                    'unit' => $supply->unit,
                    'alert_level' => $this->calculateAlertLevel($supply)
                ];
            });
    }

    /**
     * Calculate alert level based on stock status
     */
    private function calculateAlertLevel(Supply $supply): string
    {
        $ratio = $supply->stock_quantity / $supply->minimum_stock;
        
        if ($ratio <= 0.5) return 'critical';
        if ($ratio <= 0.75) return 'warning';
        if ($ratio <= 1) return 'notice';
        
        return 'normal';
    }

    /**
     * Generate consumption report for a given period
     */
    public function generateConsumptionReport(string $period = 'month'): array
    {
        $startDate = $this->getStartDate($period);
        
        $consumptionData = Supply::select(
            'category',
            DB::raw('SUM(consumption_quantity) as total_consumption'),
            DB::raw('AVG(unit_price * consumption_quantity) as total_cost')
        )
        ->where('updated_at', '>=', $startDate)
        ->groupBy('category')
        ->get();

        $topConsumed = Supply::select(
            'name',
            'sku',
            'category',
            DB::raw('SUM(consumption_quantity) as total_consumption')
        )
        ->where('updated_at', '>=', $startDate)
        ->groupBy('name', 'sku', 'category')
        ->orderByDesc('total_consumption')
        ->limit(10)
        ->get();

        return [
            'period' => $period,
            'start_date' => $startDate->format('Y-m-d'),
            'end_date' => now()->format('Y-m-d'),
            'consumption_by_category' => $consumptionData,
            'top_consumed_items' => $topConsumed
        ];
    }

    /**
     * Get start date based on period
     */
    private function getStartDate(string $period): Carbon
    {
        return match($period) {
            'week' => now()->subWeek(),
            'month' => now()->subMonth(),
            'quarter' => now()->subQuarter(),
            'year' => now()->subYear(),
            default => now()->subMonth(),
        };
    }

    /**
     * Get category statistics
     */
    public function getCategoryStatistics(): array
    {
        $categories = Supply::select('category')
            ->selectRaw('COUNT(*) as total_items')
            ->selectRaw('SUM(stock_quantity * unit_price) as total_value')
            ->selectRaw('AVG(stock_quantity) as avg_stock')
            ->selectRaw('COUNT(CASE WHEN stock_quantity <= minimum_stock THEN 1 END) as low_stock_items')
            ->groupBy('category')
            ->get();

        return [
            'categories' => $categories,
            'total_categories' => $categories->count(),
            'total_value' => $categories->sum('total_value'),
            'categories_with_alerts' => $categories->where('low_stock_items', '>', 0)->count()
        ];
    }
}
