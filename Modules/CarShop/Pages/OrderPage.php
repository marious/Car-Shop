<?php


namespace Modules\CarShop\Pages;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Modules\Base\Services\Resource\Page;
use Modules\CarShop\Entities\CarBrand;
use Modules\CarShop\Entities\CarModel;
use Modules\CarShop\Entities\CarShop;
use Modules\CarShop\Transformers\CarBrandResource;
use Modules\CarShop\Transformers\CarModelResource;
use Modules\CarShop\Transformers\PremimuTotalResource;
use Modules\Insurance\Entities\Company;

class OrderPage extends Page
{
    public ?string $path = "order";
    public ?string $group = "Order";
    public ?string $icon = "bx bxs-circle";


    public function index()
    {
        $showCommission = false;
        $showQuotation = false;

        if (Auth::user()->is_admin || Auth::user()->user_type == 1) {
            $showCommission = true;
            $showQuotation = true;
        }

        return Inertia::render('@CarShop::Order', [
            'carBrands' => CarBrandResource::collection(CarBrand::all()),
            'showCommission' => $showCommission,
            'showQuotation' => $showQuotation,
        ]);
    }


    public function getSubBrand($id)
    {
        return CarModelResource::collection(CarModel::where('car_brand_id', $id)->get());
    }

    public function getSingleDetail(Request $request)
    {
        try {
            $validated = $request->validate([
                'year' => 'required|numeric',
                'price' => 'required|numeric',
                'brandId' => ['required'],
                'subBrandId' => ['required'],
                'companyId' => ['required'],
            ]);

            $subBrandId = $request['subBrandId'];
            $compoanyId = $request['companyId'];

            $premiumTotals = collect(DB::select("CALL `sp_get_premuim`({$subBrandId}, $compoanyId, {$request['price']}, {$request['year']}, 1); "));

            $fees = $premiumTotals->map(function ($item) {
                return ['name' => my_lang($item->fees_name), 'amount' => $item->fees_amount];
            });

            $newTotals = collect([
                'car_brand_name' => my_lang($premiumTotals->first()->car_brand_name),
                'car_model_name' => my_lang($premiumTotals->first()->car_model_name),
                'rate' => $premiumTotals->first()->rate,
                'premium' => $premiumTotals->first()->premium,
                'fees' => $fees,
                'commission' => $premiumTotals->first()->commission,
//            'fees_name' => $premiumTotals->pluck('fees_name'),
//            'fees_amount' => $premiumTotals->pluck('fees_amount'),
            ]);

            return response()->json($newTotals);
        } catch (Exception $e) {
            return back()->with('alert', [
                'type' => 'error',
                'message' => 'Error Not Found this record'
            ]);
        }


    }

    public function getResult(Request $request)
    {

        $validated = $request->validate([
            'year' => 'required|numeric',
            'price' => 'required|numeric',
            'brands' => ['required', 'array'],
            'subBrand' => ['required', 'array'],
        ]);

        $subBrandId = $request['subBrand']['id'];

        $companies = Company::all();

        $premiumTotals = [];

        foreach ($companies as $company) {
            $premiumTotals[] = DB::select("CALL `sp_get_premuim_total`({$subBrandId}, $company->id, {$request['price']}, {$request['year']}, 1); ");
        }


        $returned = [];
        foreach ($premiumTotals as $item) {
            if ($item && $item[0]->rate != 0) {
                $returned[] = PremimuTotalResource::make($item[0]);
            }
        }

        return $returned;
    }

    public function orderPdf(Request $request)
    {
        try {
            $validated = $request->validate([
                'year' => 'required|numeric',
                'price' => 'required|numeric',
                'brandId' => ['required'],
                'subBrandId' => ['required'],
                'companyId' => ['required'],
            ]);

            $company = Company::findOrFail($request['companyId']);


            $subBrandId = $request['subBrandId'];
            $compoanyId = $request['companyId'];

            $premiumTotals = collect(DB::select("CALL `sp_get_premuim`({$subBrandId}, $compoanyId, {$request['price']}, {$request['year']}, 1); "));

            $fees = $premiumTotals->map(function ($item) {
                return ['name' => my_lang($item->fees_name, 'ar'), 'amount' => $item->fees_amount];
            });


            $newTotals = collect([
                'car_brand_name' => my_lang($premiumTotals->first()->car_brand_name),
                'car_model_name' => my_lang($premiumTotals->first()->car_model_name),
                'rate' => $premiumTotals->first()->rate,
                'premium' => $premiumTotals->first()->premium,
                'fees' => $fees,
                'commission' => $premiumTotals->first()->commission,
                'year' => $request['year'],
                'price' => $request['price'],
//            'fees_name' => $premiumTotals->pluck('fees_name'),
//            'fees_amount' => $premiumTotals->pluck('fees_amount'),
            ]);


//            Pdf::setOption(['dpi' => 150, 'defaultFont' => 'arial']);
            $defaultConfig = (new \Mpdf\Config\ConfigVariables())->getDefaults();
            $defaultFontConfig = (new \Mpdf\Config\FontVariables())->getDefaults();
            $fontData = $defaultFontConfig['fontdata'];
            $fontDirs = $defaultConfig['fontDir'];
            $mpdf = new \Mpdf\Mpdf([
                'autoArabic' => true,
                'mode' => 'utf-8',
                'fontDir' => array_merge($fontDirs, [
                    public_path('assets/fonts')
                ]),

                'fontdata' => $fontData + [
                        'almarai' => [
                            'R' => 'Almarai-Regular.ttf',
                            'I' => 'Almarai-Regular.ttf',
                            'useOTL' => 0xFF,
                            'useKashida' => 75,
                        ]
                    ],
                'default_font' => 'almarai'
            ]);
            $mpdf->SetDirectionality('rtl');
            $html = view('carshop::pdf.order', [
                'info' => $newTotals,
                'terms' => $company->terms_conditions
            ])->render();
            $mpdf->WriteHTML($html);
            $mpdf->SetJS('this.print();');
            $mpdf->output();
            exit;
        } catch (Exception $e) {
            Log::error($e);
            return back()->with('alert', [
                'type' => 'error',
                'message' => 'Error Not Found this record'
            ]);
        }

    }
}
