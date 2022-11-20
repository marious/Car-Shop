<?php

namespace Modules\Insurance\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Modules\Insurance\Http\Requests\CompanyPrice\IndexCompanyPriceRequest;
use Modules\Insurance\Http\Requests\CompanyPrice\StoreCompanyPriceRequest;
use Modules\Insurance\Http\Requests\CompanyPrice\UpdateCompanyPriceRequest;
use Modules\Insurance\Http\Requests\CompanyPrice\DestroyCompanyPriceRequest;
use Illuminate\Support\Facades\Redirect;
use Modules\Insurance\Http\Resources\Inertia\CompanyPriceResource;
use Modules\Insurance\Entities\CompanyPrice;
use Modules\Insurance\Repositories\CompanyPriceRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;

class CompanyPriceController extends Controller
{
    private CompanyPriceRepository $repo;

    public function __construct(CompanyPriceRepository $repo)
    {
        $this->repo = $repo;
    }


    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return  \Inertia\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Request $request): \Inertia\Response
    {
        $this->authorize('viewAny', CompanyPrice::class);
        $companyPrices = CompanyPriceResource::collection(
            CompanyPrice::query()
                ->when($request->input('search'), function ($query, $search) {
                    $query->whereRaw('LOWER(JSON_EXTRACT(name, "$.en")) like ?', ['"%' . strtolower($search) . '%"'])
                        ->orWhereRaw('LOWER(JSON_EXTRACT(name, "$.ar")) like ?', ['"%' . strtolower($search) . '%"']);
                })
                ->with(['company', 'price'])
                ->paginate(15)
                ->withQueryString()
        );
        return Inertia::render('@Insurance::CompanyPrice/Index', [
            "can" => [
                "viewAny" => \Auth::user()->can('viewAny', CompanyPrice::class),
                "create" => \Auth::user()->can('create', CompanyPrice::class),
            ],
            'filters' => $request->only('search'),
            "company-prices" => $companyPrices,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Inertia\Response
     */
    public function create()
    {
        $this->authorize('create', CompanyPrice::class);
        return Inertia::render("@Insurance::CompanyPrice/Create", [
            "can" => [
                "viewAny" => \Auth::user()->can('viewAny', CompanyPrice::class),
                "create" => \Auth::user()->can('create', CompanyPrice::class),
            ]
        ]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param StoreCompanyPrice $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreCompanyPriceRequest $request)
    {
        try {
            $data = $request->sanitizedObject();
            $companyPrice = $this->repo::store($data);
            return Redirect::route('company-prices.index')->with('alert', [
                'type' => 'success',
                'message' => 'CompanyPrice Created Successfully'
            ]);
        } catch (\Throwable $exception) {
            \Log::error($exception);
            return back()->with([
                'alert' => [
                    'type' => 'error',
                    'message' => __('Cannot Store data'),
                ],
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param CompanyPrice $companyPrice
     * @return \Inertia\Response|\Illuminate\Http\RedirectResponse
     */
    public function show(Request $request, CompanyPrice $companyPrice)
    {
        try {
            $this->authorize('view', $companyPrice);
            $model = $this->repo::init($companyPrice)->show($request);
            return Inertia::render("CompanyPrices/Show", ["model" => $model]);
        } catch (\Throwable $exception) {
            \Log::error($exception);
            return back()->with([
                'error' => $exception->getMessage(),
            ]);
        }
    }

    /**
     * Show Edit Form for the specified resource.
     *
     * @param Request $request
     * @param CompanyPrice $companyPrice
     * @return \Inertia\Response|\Illuminate\Http\RedirectResponse
     */
    public function edit(Request $request, CompanyPrice $companyPrice)
    {
        try {
            $this->authorize('update', $companyPrice);
            //Fetch relationships
            $companyPrice->load([
                'company',
                'price',
            ]);
            return Inertia::render("@Insurance::CompanyPrice/Edit", ["model" => CompanyPriceResource::make
            ($companyPrice)]);
        } catch (\Throwable $exception) {
            \Log::error($exception);
            return back()->with('alert', [
                'type' => 'error',
                'message' => $exception->getMessage(),
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateCompanyPrice $request
     * @param {$modelBaseName} $companyPrice
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateCompanyPriceRequest $request, CompanyPrice $companyPrice)
    {
        try {
            $data = $request->sanitizedObject();
            $res = $this->repo::init($companyPrice)->update($data);
            return Redirect::route('company-prices.index')->with('alert', [
                'type' => 'success',
                'message' => 'CompanyPrice Updated Successfully'
            ]);
        } catch (\Throwable $exception) {
            \Log::error($exception);
            return back()->with('alert', [
                'type' => 'error',
                'message' => $exception->getMessage(),
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param CompanyPrice $companyPrice
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(DestroyCompanyPriceRequest $request, CompanyPrice $companyPrice)
    {
        $res = $this->repo::init($companyPrice)->destroy();
        if ($res) {
            return back()->with('alert', [
                'type' => 'success',
                'message' => "The CompanyPrice was deleted successfully."
            ]);
        } else {
            return back()->with(['alert',
                'type' => 'error',
                'message' => "The CompanyPrice could not be deleted."
            ]);
        }
    }

}
