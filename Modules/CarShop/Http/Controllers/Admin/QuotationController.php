<?php

namespace Modules\CarShop\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Modules\CarShop\Entities\Quotation;
use Modules\CarShop\Http\Requests\QuotationLicenceRequest;
use Modules\CarShop\Http\Requests\StoreQuotationRequest;

class QuotationController extends Controller
{

    public function index()
    {
        return Inertia::render('@CarShop::Quotation/index');
    }

    public function approved()
    {
        return Inertia::render('@CarShop::Quotation/approved');
    }

    public function show($id)
    {
        $quotation = Quotation::where('id', $id)
                ->with(['company', 'brand', 'model', 'fees'])
                ->firstOrFail();
        $medias = $quotation->getMedia('attachments')->toArray();

        return Inertia::render("@CarShop::Quotation/view", [
            'quotation' => $quotation,
            'medias' => $medias,
            'showApproved' => auth()->user()->is_admin,

        ]);
    }

    public function store(StoreQuotationRequest $request)
    {
        $data = $request->validated();
        $request->merge(['user_id' => auth()->user()->id]);
        $request['birth_date'] = Carbon::parse($request->input('birth_date'))->setTimezone('Africa/Cairo')->format('Y-m-d');


        try {
            $quotation = Quotation::create($request->all());

            $total = DB::select("CALL `sp_get_premuim_total`({$data['model_id']}, {$data['company_id']}, {$data['price']}, {$data['year']}, 1); ");
            $totalAndFees = collect(DB::select("CALL `sp_get_premuim`({$data['model_id']}, {$data['company_id']}, {$data['price']}, {$data['year']}, 1); "));

            $quotation->rate = $total[0]->rate;
            $quotation->premium = $total[0]->premium;
            $quotation->total_premium = $total[0]->total_premim;
            $quotation->commission = $total[0]->commission;
            $quotation->sum_insured = $total[0]->sum_insured;
            $quotation->car_shop_id = auth()->user()->car_shop_id;

            $quotation->save();

            foreach ($totalAndFees as $item) {
                $quotation->fees()->attach($item->fee_id, ['amount' => $item->fees_amount]);
            }

            if (isset($request->attachments) && $request->attachments) {
                $quotation->addMultipleMediaFromRequest(['attachments'])->each(function ($fileAdder) {
                    $fileAdder->toMediaCollection('attachments');
                });
            }

        } catch (\Exception $e) {
           Log::error($e->getMessage());
        }
    }

    public function update(QuotationLicenceRequest $request, $id)
    {
        if (auth()->user()->is_admin) {
            $quotation = Quotation::where('id', $id)->firstOrFail();
            $quotation->policy_num = $request->input('policyNum');
            $quotation->policy_year = Carbon::parse($request->input('birth_date'))->setTimezone('Africa/Cairo')->format('Y');
            $quotation->is_approved = 1;
            $quotation->approved_at = now();
            $quotation->save();
        }

    }

}
