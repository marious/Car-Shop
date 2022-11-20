<?php

namespace Modules\Base\Http\Controllers;

use Carbon\Carbon;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Modules\Base\Services\Components\Base\Render;
use Modules\CarShop\Entities\Accident;
use Modules\CarShop\Entities\Quotation;

class DashboardController extends Controller
{
    public function index()
    {
        $quotationsEntered = [];
        $accidentEntered = [];

        for ($i = 1; $i <= 12; $i++) {
            $from = date('Y-'.$i.'-01');
            $to = date('Y')."-{$i}-" . cal_days_in_month(CAL_GREGORIAN, $i, date('Y'));
            $from = Carbon::createFromFormat('Y-m-d', $from)->startOfDay();
            $to = Carbon::createFromFormat('Y-m-d', $to)->endOfDay();

            $quotationsEntered[] = Quotation::whereBetween('created_at', [$from, $to])->count();
            $accidentEntered[] = Accident::whereBetween('created_at', [$from, $to])->count();
        }


        return Render::make('dashboard/Index')->data(
            [
                'quotationEntered' => $quotationsEntered,
                'accidentEntered' => $accidentEntered,
                'isAdmin' => auth()->user()->is_admin,
            ]
        )->module('Base')->render();
    }

    public function logout()
    {
        auth('web')->logout();
        return redirect()->route('login');
    }

    public function select(Request $request){
        $request->validate([
           "model_type" => "required",
           "model_id" => "sometimes",
            "query" => "sometimes|boolean",
            "key" => "sometimes|string",
            "value" => "sometimes"
        ]);

        if($request->has('model_id')){
            $records = $request->get('model_type')::find($request->get('model_id'));
        }
        else if($request->has('query') && $request->has('query') == true){
            $records = $request->get('model_type')::where($request->get('key'), 'LIKE', '%' .$request->get('value').'%')->paginate(10);
        }
        else {
            $records = $request->get('model_type')::orderBy('id', 'desc')->paginate(10);
        }

        if($records){
            return response()->json([
                "success" => true,
                "message" => "Record loaded success",
                "data" => $records
            ]);
        }
        else {
            return response()->json([
                "success" => false,
                "message" => "Record not found"
            ], 404);
        }

    }
}
