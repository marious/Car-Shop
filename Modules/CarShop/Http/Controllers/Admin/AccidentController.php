<?php

namespace Modules\CarShop\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Modules\CarShop\Entities\Accident;
use Modules\CarShop\Entities\Quotation;
use Modules\CarShop\Http\Requests\StoreAccidentRequest;

class AccidentController extends Controller
{
    public function make($quotationId)
    {
        return Inertia::render('@CarShop::Quotation/accident', [
            'quotationId' => $quotationId,
            'showFinancial' => auth()->user()->is_admin,
        ]);
    }

    public function show($quotationId)
    {
        try {
            $accident = Accident::where('quotation_id', $quotationId)
                ->with(['quotation', 'quotation.company',
                    'quotation.model', 'quotation.brand'])
                ->firstOrFail();
            $medias = $accident->getMedia('attachments')->toArray();
            $isAdmin = auth()->user()->is_admin;
            return Inertia::render('@CarShop::Quotation/accidentItem', [
                'accident' => $accident,
                'medias' => $medias,
                'isAdmin' => $isAdmin,
            ]);
        } catch (\Throwable $exception) {
            \Log::error($exception);
            return Redirect::route('quotations.approved')->with('alert', [
                'type' => 'error',
                'message' => $exception->getMessage()
            ]);
        }
    }

    public function store(StoreAccidentRequest $request, $quotationId)
    {
        $validated = $request->validated();
        $quotation = Quotation::findOrFail($quotationId);

        try {
            // check if the quotation exists before
            if (Accident::where('quotation_id', $quotationId)->count()) {
                throw new \Exception('This Quotation exist before in Accident');
            }

            $accident = Accident::create([
                'quotation_id' => $quotationId,
                'policy_num' => $quotation->policy_num,
                'accident_date' => Carbon::parse($validated['accident_date'])->setTimezone('Africa/Cairo')->format('Y-m-d'),
                'description' => $validated['description'],
                'admin_note' => $validated['admin_note'] ?: null,
                'compensation' => $validated['compensation'] ?: null,
                'payment_way' => strtolower($validated['payment_way']) ?: null,
                'account_num' => $validated['account_num'] ?: null,
                'check_num' => $validated['check_num'] ?: null,
            ]);

            $quotation->is_accident = true;
            $quotation->save();

            if (isset($request->attachments) && $request->attachments) {
                $accident->addMultipleMediaFromRequest(['attachments'])->each(function ($fileAdder) {
                    $fileAdder->toMediaCollection('attachments');
                });
            }

            return Redirect::route('quotations.approved')->with('alert', [
                'type' => 'success',
                'message' => 'Saved Successfully',
            ]);
        } catch (\Throwable $exception) {
            \Log::error($exception);
            return Redirect::route('quotations.approved')->with('alert', [
                'type' => 'error',
                'message' => $exception->getMessage()
            ]);
        }
    }
}
