<?php

namespace Modules\Insurance\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Modules\Insurance\Http\Requests\Company\IndexCompanyRequest;
use Modules\Insurance\Http\Requests\Company\StoreCompanyRequest;
use Modules\Insurance\Http\Requests\Company\UpdateCompanyRequest;
use Modules\Insurance\Http\Requests\Company\DestroyCompanyRequest;
use Illuminate\Support\Facades\Redirect;
use Modules\Insurance\Http\Resources\Inertia\CompanyResource;
use Modules\Insurance\Entities\Company;
use Modules\Insurance\Repositories\CompanyRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;

class CompanyController extends Controller
{
    private CompanyRepository $repo;

    public function __construct(CompanyRepository $repo)
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
        $this->authorize('viewAny', Company::class);
        $companies = CompanyResource::collection(
            Company::query()
                ->when($request->input('search'), function ($query, $search) {
                    $query->whereRaw('LOWER(JSON_EXTRACT(name, "$.en")) like ?', ['"%' . strtolower($search) . '%"'])
                        ->orWhereRaw('LOWER(JSON_EXTRACT(name, "$.ar")) like ?', ['"%' . strtolower($search) . '%"']);
                })
                ->paginate(15)
                ->withQueryString()
        );
        return Inertia::render('@Insurance::Company/Index', [
            "can" => [
                "viewAny" => \Auth::user()->can('viewAny', Company::class),
                "create" => \Auth::user()->can('create', Company::class),
            ],
            'filters' => $request->only('search'),
            "companies" => $companies,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Inertia\Response
     */
    public function create()
    {
        $this->authorize('create', Company::class);
        return Inertia::render("@Insurance::Company/Create", [
            "can" => [
                "viewAny" => \Auth::user()->can('viewAny', Company::class),
                "create" => \Auth::user()->can('create', Company::class),
            ]
        ]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param StoreCompany $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreCompanyRequest $request)
    {
        try {
            $data = $request->sanitizedObject();
            $company = $this->repo::store($data);
            return Redirect::route('companies.index')->with('alert', [
                'type' => 'success',
                'message' => 'Company Created Successfully'
            ]);
        } catch (\Throwable $exception) {
            \Log::error($exception);
            return back()->with([
                'alert' => [
                    'type' => 'error',
                    'message' => $exception->getMessage()
                ],
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param Company $company
     * @return \Inertia\Response|\Illuminate\Http\RedirectResponse
     */
    public function show(Request $request, Company $company)
    {
        try {
            $this->authorize('view', $company);
            $model = $this->repo::init($company)->show($request);
            return Inertia::render("Companies/Show", ["model" => $model]);
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
     * @param Company $company
     * @return \Inertia\Response|\Illuminate\Http\RedirectResponse
     */
    public function edit(Request $request, Company $company)
    {
        try {
            $this->authorize('update', $company);
            //Fetch relationships


            return Inertia::render("@Insurance::Company/Edit", ["model" => $company]);
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
     * @param UpdateCompany $request
     * @param {$modelBaseName} $company
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateCompanyRequest $request, Company $company)
    {
        try {
            $data = $request->sanitizedObject();
            $res = $this->repo::init($company)->update($data);
            return Redirect::route('companies.index')->with('alert', [
                'type' => 'success',
                'message' => 'Company Updated Successfully'
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
     * @param Company $company
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(DestroyCompanyRequest $request, Company $company)
    {
        $res = $this->repo::init($company)->destroy();
        if ($res) {
            return back()->with('alert', [
                'type' => 'success',
                'message' => "The Company was deleted successfully."
            ]);
        } else {
            return back()->with(['alert',
                'type' => 'error',
                'message' => "The Company could not be deleted."
            ]);
        }
    }

}
