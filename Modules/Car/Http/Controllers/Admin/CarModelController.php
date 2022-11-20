<?php

namespace Modules\Car\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Modules\Car\Http\Requests\CarModel\StoreCarModelRequest;
use Modules\Car\Http\Requests\CarModel\UpdateCarModelRequest;
use Modules\Car\Http\Requests\CarModel\DestroyCarModelRequest;
use Illuminate\Support\Facades\Redirect;
use Modules\Car\Http\Resources\Inertia\CarModelResource;
use Modules\Car\Entities\CarModel;
use Modules\Car\Repositories\CarModelRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;

class CarModelController extends Controller
{
    private CarModelRepository $repo;

    public function __construct(CarModelRepository $repo)
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
        $this->authorize('viewAny', CarModel::class);

//        return CarModelResource::collection(CarModel::all());

        $carModels = CarModelResource::collection(
            CarModel::query()
                ->when($request->input('search'), function ($query, $search) {
                    $query->whereRaw('LOWER(JSON_EXTRACT(name, "$.en")) like ?', ['"%' . strtolower($search) . '%"'])
                        ->orWhereRaw('LOWER(JSON_EXTRACT(name, "$.ar")) like ?', ['"%' . strtolower($search) . '%"']);
                })
                ->with('carBrand')
                ->paginate(15)
                ->withQueryString()
        );

        return Inertia::render('@Car::CarModel/Index', [
            "can" => [
                "viewAny" => \Auth::user()->can('viewAny', CarModel::class),
                "create" => \Auth::user()->can('create', CarModel::class),
            ],
            'filters' => $request->only('search'),
            "car-models" => $carModels,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Inertia\Response
     */
    public function create()
    {
        $this->authorize('create', CarModel::class);

        return Inertia::render("@Car::CarModel/Create", [
            "can" => [
                "viewAny" => \Auth::user()->can('viewAny', CarModel::class),
                "create" => \Auth::user()->can('create', CarModel::class),
            ]
        ]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param StoreCarModel $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreCarModelRequest $request)
    {
        try {
            $data = $request->sanitizedObject();
            $carModel = $this->repo::store($data);
            return Redirect::route('car-models.index')->with('alert', [
                'type' => 'success',
                'message' => 'CarModel Created Successfully'
            ]);
        } catch (\Throwable $exception) {
            \Log::error($exception);
            return back()->with('alert', [
                    'type' => 'error',
                    'message' => $exception->getMessage()
                ],
            );
        }
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param CarModel $carModel
     * @return \Inertia\Response|\Illuminate\Http\RedirectResponse
     */
    public function show(Request $request, CarModel $carModel)
    {
        try {
            $this->authorize('view', $carModel);
            $model = $this->repo::init($carModel)->show($request);
            return Inertia::render("CarModels/Show", ["model" => $model]);
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
     * @param CarModel $carModel
     * @return \Inertia\Response|\Illuminate\Http\RedirectResponse
     */
    public function edit(Request $request, CarModel $carModel)
    {
        try {
            $this->authorize('update', $carModel);
            $carModel->load([
                'carBrand',
            ]);
            return Inertia::render("@Car::CarModel/Edit", ["model" => $carModel]);
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
     * @param UpdateCarModel $request
     * @param {$modelBaseName} $carModel
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateCarModelRequest $request, CarModel $carModel)
    {
        try {
            $data = $request->sanitizedObject();
            $res = $this->repo::init($carModel)->update($data);
            return Redirect::route('car-models.index')->with('alert', [
                'type' => 'success',
                'message' => 'CarModel Updated Successfully'
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
     * @param CarModel $carModel
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(DestroyCarModelRequest $request, CarModel $carModel)
    {
        $res = $this->repo::init($carModel)->destroy();
        if ($res) {
            return back()->with('alert', [
                'type' => 'success',
                'message' => "The CarModel was deleted succesfully."
            ]);
        } else {
            return back()->with(['alert',
                'type' => 'error',
                'message' => "The CarModel could not be deleted."
            ]);
        }
    }

}
