<?php

namespace Modules\Car\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Exception;
use Modules\Car\Http\Requests\CarBrand\IndexCarBrandRequest;
use Modules\Car\Http\Requests\CarBrand\StoreCarBrandRequest;
use Modules\Car\Http\Requests\CarBrand\UpdateCarBrandRequest;
use Modules\Car\Http\Requests\CarBrand\DestroyCarBrandRequest;
use Illuminate\Support\Facades\Redirect;
use Modules\Car\Http\Resources\Inertia\CarBrandResource;
use Modules\Car\Entities\CarBrand;
use Modules\Car\Repositories\CarBrandRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;

class CarBrandController extends Controller
{
    private CarBrandRepository $repo;

    public function __construct(CarBrandRepository $repo)
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
        $this->authorize('viewAny', CarBrand::class);

        $carBrands = CarBrandResource::collection(
            CarBrand::query()
                ->when($request->input('search'), function ($query, $search) {
                    $query->whereRaw('LOWER(JSON_EXTRACT(name, "$.en")) like ?', ['"%' . strtolower($search) . '%"'])
                        ->orWhereRaw('LOWER(JSON_EXTRACT(name, "$.ar")) like ?', ['"%' . strtolower($search) . '%"']);
                })
                ->paginate(15)
                ->withQueryString()
        );
        return Inertia::render('@Car::CarBrand/Index', [
            "can" => [
                "viewAny" => \Auth::user()->can('viewAny', CarBrand::class),
                "create" => \Auth::user()->can('create', CarBrand::class),
            ],
            'filters' => $request->only('search'),
            "car-brands" => $carBrands,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Inertia\Response
     */
    public function create()
    {
        //  $this->authorize('create', CarBrand::class);

        return Inertia::render("@Car::CarBrand/Create", [
            "can" => [
                "viewAny" => \Auth::user()->can('viewAny', CarBrand::class),
                "create" => \Auth::user()->can('create', CarBrand::class),
            ]
        ]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param StoreCarBrand $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreCarBrandRequest $request)
    {
        try {
            $data = $request->sanitizedObject();
            $carBrand = $this->repo::store($data);
            return Redirect::route('car-brands.index')->with('alert', [
                'type' => 'success',
                'message' => 'CarBrand Created Successfully'
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
     * @param CarBrand $carBrand
     * @return \Inertia\Response|\Illuminate\Http\RedirectResponse
     */
    public function show(Request $request, CarBrand $carBrand)
    {
        try {
            // $this->authorize('view', $carBrand);
            $model = $this->repo::init($carBrand)->show($request);
            return Inertia::render("CarBrands/Show", ["model" => $model]);
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
     * @param CarBrand $carBrand
     * @return \Inertia\Response|\Illuminate\Http\RedirectResponse
     */
    public function edit(Request $request, CarBrand $carBrand)
    {
        try {
            //    $this->authorize('update', $carBrand);
            //Fetch relationships


            return Inertia::render("@Car::CarBrand/Edit", ["model" => $carBrand]);
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
     * @param UpdateCarBrand $request
     * @param {$modelBaseName} $carBrand
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateCarBrandRequest $request, CarBrand $carBrand)
    {
        try {
            $data = $request->sanitizedObject();
            $res = $this->repo::init($carBrand)->update($data);
            return Redirect::route('car-brands.index')->with('alert', [
                'type' => 'success',
                'message' => 'CarBrand Updated Successfully'
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
     * @param CarBrand $carBrand
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(DestroyCarBrandRequest $request, CarBrand $carBrand)
    {
        try {
            $res = $this->repo::init($carBrand)->destroy();
            return back()->with('alert', [
                'type' => 'success',
                'message' => "The CarBrand was deleted Successfuly."
            ]);
        } catch (Exception $e) {
            return back()->with('alert', [
                'type' => 'error',
                'message' => $e->getMessage(),
            ]);
        }
    }

}
