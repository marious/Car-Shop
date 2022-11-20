<?php

namespace Modules\Insurance\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Support\Facades\DB;
use Modules\Car\Entities\CarBrand;
use Modules\Car\Entities\CarModel;
use Modules\Insurance\Http\Requests\CompanyCarModel\IndexCompanyCarModelRequest;
use Modules\Insurance\Http\Requests\CompanyCarModel\StoreCompanyCarModelRequest;
use Modules\Insurance\Http\Requests\CompanyCarModel\UpdateCompanyCarModelRequest;
use Modules\Insurance\Http\Requests\CompanyCarModel\DestroyCompanyCarModelRequest;
use Illuminate\Support\Facades\Redirect;
use Modules\Insurance\Http\Resources\Inertia\CompanyCarModelResource;
use Modules\Insurance\Entities\CompanyCarModel;
use Modules\Insurance\Http\Resources\Inertia\CompanyCarModelResourceAdvance;
use Modules\Insurance\Repositories\CompanyCarModelRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;

class CompanyCarModelController extends Controller
{
    private CompanyCarModelRepository $repo;

    public function __construct(CompanyCarModelRepository $repo)
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
    public function index(Request $request)
    {
        $this->authorize('viewAny', CompanyCarModel::class);


        $data = DB::table('company_car_model')
            ->selectRaw('`car_brands`.`id` AS `brand_id`,
            `company_car_model`.`company_id`,
             `company_car_model`.`category`,
              MAX(company_car_model.id) AS id,
              GROUP_CONCAT(company_car_model.car_model) AS car_model
')
            ->join('car_models', 'company_car_model.car_model', '=', 'car_models.id')
            ->join('car_brands', 'car_models.car_brand_id', '=', 'car_brands.id')
            ->groupBy('car_brands.id','company_car_model.company_id', 'company_car_model.category')
            ->paginate(15);


        $companyCarModels = CompanyCarModelResourceAdvance::collection($data);

        return Inertia::render('@Insurance::CompanyCarModel/Index', [
            "can" => [
                "viewAny" => \Auth::user()->can('viewAny', CompanyCarModel::class),
                "create" => \Auth::user()->can('create', CompanyCarModel::class),
                "delete" => true,
            ],
            'filters' => $request->only('search'),
            "company-car-models" => $companyCarModels,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Inertia\Response
     */
    public function create()
    {
        $this->authorize('create', CompanyCarModel::class);
        return Inertia::render("@Insurance::CompanyCarModel/Create", [
            "can" => [
                "viewAny" => \Auth::user()->can('viewAny', CompanyCarModel::class),
                "create" => \Auth::user()->can('create', CompanyCarModel::class),
            ]
        ]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param StoreCompanyCarModel $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreCompanyCarModelRequest $request)
    {
        try {
            $data = $request->sanitizedObject();
            $companyCarModel = $this->repo::store($data);
            return Redirect::route('company-car-models.index')->with('alert', [
                'type' => 'success',
                'message' => 'CompanyCarModel Created Successfully'
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
     * @param CompanyCarModel $companyCarModel
     * @return \Inertia\Response|\Illuminate\Http\RedirectResponse
     */
    public function show(Request $request, CompanyCarModel $companyCarModel)
    {
        try {
            $this->authorize('view', $companyCarModel);
            $model = $this->repo::init($companyCarModel)->show($request);
            return Inertia::render("CompanyCarModels/Show", ["model" => $model]);
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
     * @param CompanyCarModel $companyCarModel
     * @return \Inertia\Response|\Illuminate\Http\RedirectResponse
     */
    public function edit(Request $request, CompanyCarModel $companyCarModel)
    {
        $data = $this->repo->getRelatedCarModelBrand($companyCarModel);

        $carModels = [];
        $carBrand = [];

        foreach ($data->pluck('car_model') as $item) {
            $carModels[] = ['id' => $item, 'name' => CarModel::select('name')->where('id', $item)->first()->name];
        }


        $carBrand = ['id' => $data[0]->brand_id, 'name' => CarBrand::select('name')->where('id', $data[0]->brand_id)
            ->first()->name];

        try {
            $this->authorize('update', $companyCarModel);
            $companyCarModel->load([
                'company',
            ]);
            $companyCarModel->car_models = $carModels;
            $companyCarModel->car_brand = $carBrand;

            return Inertia::render("@Insurance::CompanyCarModel/Edit", ["model" => $companyCarModel]);
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
     * @param UpdateCompanyCarModel $request
     * @param {$modelBaseName} $companyCarModel
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateCompanyCarModelRequest $request, CompanyCarModel $companyCarModel)
    {

        try {
            $data = $request->sanitizedObject();
            $res = $this->repo::init($companyCarModel)->update($data);
            return Redirect::route('company-car-models.index')->with('alert', [
                'type' => 'success',
                'message' => 'CompanyCarModel Updated Successfully'
            ]);
        } catch (Exception $exception) {
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
     * @param CompanyCarModel $companyCarModel
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(DestroyCompanyCarModelRequest $request, CompanyCarModel $companyCarModel)
    {
        $res = $this->repo::init($companyCarModel)->destroy();
        if ($res) {
            return back()->with('alert', [
                'type' => 'success',
                'message' => "The CompanyCarModel was deleted successfully."
            ]);
        } else {
            return back()->with(['alert',
                'type' => 'error',
                'message' => "The CompanyCarModel could not be deleted."
            ]);
        }
    }

}
