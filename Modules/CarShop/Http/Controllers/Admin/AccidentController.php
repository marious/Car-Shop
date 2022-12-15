<?php

namespace Modules\CarShop\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use http\Env\Request;
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


    public function accidentList($quotationId)
    {
        try {
            $accidents = Accident::where('quotation_id', $quotationId)
                ->with(['quotation', 'quotation.company',
                    'quotation.model', 'quotation.brand'])
                ->orderBy('created_at', 'desc')
                ->get();
            return Inertia::render('@CarShop::Quotation/accidentList', [
                'accidents' => $accidents,
            ]);
        } catch (\Throwable $exception) {
            \Log::error($exception);
            return Redirect::route('quotations.approved')->with('alert', [
                'type' => 'error',
                'message' => $exception->getMessage(),
            ]);
        }
    }

    public function show($id)
    {
        try {
            $accident = Accident::where('id', $id)
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
                'message' => __('Saved Successfully'),
            ]);
        } catch (\Throwable $exception) {
            \Log::error($exception);
            return Redirect::route('quotations.approved')->with('alert', [
                'type' => 'error',
                'message' => $exception->getMessage()
            ]);
        }
    }

    public function edit($accidentId)
    {
        $accident = Accident::findOrFail($accidentId);
        $medias = $accident->getMedia('attachments');
        return Inertia::render('@CarShop::Quotation/edit_accident', [
            'accident' => $accident,
            'showFinancial' => auth()->user()->is_admin,
            'medias' => $medias->count() ? $medias->toArray() : [],
        ]);
    }

    public function update(StoreAccidentRequest $request, Accident $accident)
    {
        $validated = $request->validated();

        $accident->accident_date = Carbon::parse($validated['accident_date'])->setTimezone('Africa/Cairo')->format('Y-m-d');
        $accident->description = $validated['description'];
        $accident->admin_note = $validated['admin_note'] ? $validated['admin_note'] : null;
        $accident->compensation = $validated['compensation'] ? $validated['compensation'] : null;
        $accident->payment_way = $validated['payment_way'] ? $validated['payment_way'] : null;
        $accident->account_num = $validated['account_num'] ? $validated['account_num'] : null;
        $accident->check_num = $validated['check_num'] ? $validated['check_num'] : null;

        $accident->update();

        $this->processMediaOnUpdate($request, $accident);


        return Redirect::route('quotations.approved')->with('alert', [
            'type' => 'success',
            'message' => __('Updated Successfully'),
        ]);

    }

    public function processMediaOnUpdate($request, $record): void
    {
        if ($request->attachments && is_array($request->attachments)) {
            $hasNewMedia = false;
            foreach ($request->attachments as $item) {
                if ($item->getClientOriginalName() !== 'blob') {
                    $hasNewMedia = true;
                }
            }
            if ($hasNewMedia) {
                $record->clearMediaCollection('attachments');
                foreach ($request->attachments as $item) {
                    $record->addMedia($item)
                        ->preservingOriginal()
                        ->toMediaCollection('attachments');
                }
            }
        } else if (empty($request->get($field->name))) {
            $record->clearMediaCollection('attachments');
        }
    }
}
