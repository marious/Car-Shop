<?php

namespace Modules\Report\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Modules\CarShop\Entities\CarShop;
use Modules\CarShop\Entities\Quotation;

class ReportController extends Controller
{

    public function index()
    {
        $carShops = CarShop::select('id', 'name', 'commission')->get();
        return Inertia::render('@Report::Index', [
            'carShops' => $carShops,
        ]);
    }

    public function search(Request $request)
    {
        $validated = $request->validate([
            'fromDate' => 'required|date',
            'toDate' => 'required|date|after:fromDate',
            'carShop' => 'nullable',
        ]);


        $fromDate = Carbon::parse($request->input('fromDate'))->setTimezone('Africa/Cairo')->format('Y-m-d');
        $toDate = Carbon::parse($request->input('toDate'))->setTimezone('Africa/Cairo')->format('Y-m-d');
        $carShop = $request->input('carShop');
        $carShopId = false;

        if ($carShop) {
            $carShopId = $carShop['id'];
        }

        $result = Quotation::query()
            ->select([
                'car_shop_id',
                DB::raw('COUNT(id) AS policy_count'),
                DB::raw('SUM(premium) AS total_net_premium'),
                DB::raw('SUM(total_premium) AS total_gross_premium'),
                DB::raw('SUM(commission) AS commission'),
            ])
            ->where('is_approved', true)
            ->whereBetween('approved_at', [$fromDate, $toDate])
            ->whereNotNull('car_shop_id')
            ->when($carShopId, fn ($query) => $query->where('car_shop_id', $carShopId))
            ->groupBy('car_shop_id')
            ->with('carShop', fn($q) => $q->select('id', 'name'))
            ->get()
            ->toArray();

        return $result;
    }
}
