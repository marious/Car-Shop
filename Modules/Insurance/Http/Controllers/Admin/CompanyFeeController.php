<?php

namespace Modules\Insurance\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Modules\Insurance\Entities\Company;
use Modules\Insurance\Http\Requests\CompanyFee\IndexCompanyFeeRequest;
use Modules\Insurance\Http\Requests\CompanyFee\StoreCompanyFeeRequest;
use Modules\Insurance\Http\Requests\CompanyFee\UpdateCompanyFeeRequest;
use Modules\Insurance\Http\Requests\CompanyFee\DestroyCompanyFeeRequest;
use Illuminate\Support\Facades\Redirect;
use Modules\Insurance\Http\Resources\Inertia\CompanyFeeResource;
use Modules\Insurance\Entities\CompanyFee;
use Modules\Insurance\Repositories\CompanyFeeRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;

class CompanyFeeController extends Controller
{
    private CompanyFeeRepository $repo;

    public function __construct(CompanyFeeRepository $repo)
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
        $this->authorize('viewAny', CompanyFee::class);
        $companyFees = CompanyFeeResource::collection(
            CompanyFee::query()
                ->when($request->input('search'), function ($query, $search) {
                    $query->join('fees', 'fee_id', '=', 'fees.id')
                        ->join('companies', 'company_id', 'companies.id')
                        ->whereRaw('LOWER(JSON_EXTRACT(fees.name, "$.en")) like ?', ['"%' . strtolower
                            ($search) . '%"'])
                        ->orWhereRaw('LOWER(JSON_EXTRACT(companies.name, "$.en")) like ?', ['"%' . strtolower
                            ($search) . '%"']);
                })
                ->with(['fee', 'company'])
                ->paginate(15)
                ->withQueryString()
        );
        return Inertia::render('@Insurance::CompanyFee/Index', [
            "can" => [
                "viewAny" => \Auth::user()->can('viewAny', CompanyFee::class),
                "create" => \Auth::user()->can('create', CompanyFee::class),
            ],
            'filters' => $request->only('search'),
            "company-fees" => $companyFees,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Inertia\Response
     */
    public function create()
    {
        $this->authorize('create', CompanyFee::class);
        return Inertia::render("@Insurance::CompanyFee/Create", [
            "can" => [
                "viewAny" => \Auth::user()->can('viewAny', CompanyFee::class),
                "create" => \Auth::user()->can('create', CompanyFee::class),
            ]
        ]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param StoreCompanyFee $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreCompanyFeeRequest $request)
    {
        try {
            $data = $request->sanitizedObject();
            $companyFee = $this->repo::store($data);
            return Redirect::route('company-fees.index')->with('alert', [
                'type' => 'success',
                'message' => 'CompanyFee Created Successfully'
            ]);
        } catch (\Throwable $exception) {
            \Log::error($exception);
            return back()->with([
                'alert' => [
                    'type' => 'error',
                    'message' => __('Cannot store data')
                ],
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param CompanyFee $companyFee
     * @return \Inertia\Response|\Illuminate\Http\RedirectResponse
     */
    public function show(Request $request, CompanyFee $companyFee)
    {
        try {
            $this->authorize('view', $companyFee);
            $model = $this->repo::init($companyFee)->show($request);
            return Inertia::render("CompanyFees/Show", ["model" => $model]);
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
     * @param CompanyFee $companyFee
     * @return \Inertia\Response|\Illuminate\Http\RedirectResponse
     */
    public function edit(Request $request, CompanyFee $companyFee)
    {
        try {
            $this->authorize('update', $companyFee);
            //Fetch relationships

            $companyFee->load([
                'company',
                'fee',
            ]);
            return Inertia::render("@Insurance::CompanyFee/Edit", ["model" => CompanyFeeResource::make($companyFee)]);
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
     * @param UpdateCompanyFee $request
     * @param {$modelBaseName} $companyFee
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateCompanyFeeRequest $request, CompanyFee $companyFee)
    {
        try {
            $data = $request->sanitizedObject();
            $res = $this->repo::init($companyFee)->update($data);
            return Redirect::route('company-fees.index')->with('alert', [
                'type' => 'success',
                'message' => 'CompanyFee Updated Successfully'
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
     * @param CompanyFee $companyFee
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(DestroyCompanyFeeRequest $request, CompanyFee $companyFee)
    {
        $res = $this->repo::init($companyFee)->destroy();
        if ($res) {
            return back()->with('alert', [
                'type' => 'success',
                'message' => "The CompanyFee was deleted successfully."
            ]);
        } else {
            return back()->with(['alert',
                'type' => 'error',
                'message' => "The CompanyFee could not be deleted."
            ]);
        }
    }

}
