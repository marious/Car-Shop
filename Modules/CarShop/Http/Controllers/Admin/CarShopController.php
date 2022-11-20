<?php

namespace Modules\CarShop\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Modules\CarShop\Http\Requests\CarShop\IndexCarShopRequest;
use Modules\CarShop\Http\Requests\CarShop\StoreCarShopRequest;
use Modules\CarShop\Http\Requests\CarShop\UpdateCarShopRequest;
use Modules\CarShop\Http\Requests\CarShop\DestroyCarShopRequest;
use Illuminate\Support\Facades\Redirect;
use Modules\CarShop\Http\Resources\Inertia\CarShopResource;
use Modules\CarShop\Entities\CarShop;
use Modules\CarShop\Repositories\CarShopRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;

class CarShopController extends Controller
{
    private CarShopRepository $repo;

    public function __construct(CarShopRepository $repo)
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
//        $model = new CarShop();
//        dd($model->getCanAttribute());


        $this->authorize('viewAny', CarShop::class);
        $carShops = CarShopResource::collection(
            CarShop::query()
                ->when($request->input('search'), function ($query, $search) {
                    $query->whereRaw('LOWER(JSON_EXTRACT(name, "$.en")) like ?', ['"%' . strtolower($search) . '%"'])
                        ->orWhereRaw('LOWER(JSON_EXTRACT(name, "$.ar")) like ?', ['"%' . strtolower($search) . '%"']);
                })
                ->paginate(15)
                ->withQueryString()
        );

        return Inertia::render('@CarShop::CarShop/Index', [
            "can" => [
                "viewAny" => \Auth::user()->can('viewAny', CarShop::class),
                "create" => \Auth::user()->can('create', CarShop::class),
            ],
            'filters' => $request->only('search'),
            "car-shops" => $carShops,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Inertia\Response
     */
    public function create()
    {
        $this->authorize('create', CarShop::class);
        return Inertia::render("@CarShop::CarShop/Create", [
            "can" => [
                "viewAny" => \Auth::user()->can('viewAny', CarShop::class),
                "create" => \Auth::user()->can('create', CarShop::class),
            ]
        ]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param StoreCarShop $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreCarShopRequest $request)
    {
        try {
            $data = $request->sanitizedObject();
            $carShop = $this->repo::store($data);
            return Redirect::route('car-shops.index')->with('alert', [
                'type' => 'success',
                'message' => 'CarShop Created Successfully'
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
     * @param CarShop $carShop
     * @return \Inertia\Response|\Illuminate\Http\RedirectResponse
     */
    public function show(Request $request, CarShop $carShop)
    {
        try {
            $this->authorize('view', $carShop);
            $model = $this->repo::init($carShop)->show($request);
            return Inertia::render("CarShops/Show", ["model" => $model]);
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
     * @param CarShop $carShop
     * @return \Inertia\Response|\Illuminate\Http\RedirectResponse
     */
    public function edit(Request $request, CarShop $carShop)
    {
        try {
            $this->authorize('update', $carShop);

            return Inertia::render("@CarShop::CarShop/Edit", ["model" => $carShop]);
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
     * @param UpdateCarShop $request
     * @param {$modelBaseName} $carShop
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateCarShopRequest $request, CarShop $carShop)
    {
        try {
            $data = $request->sanitizedObject();
            $res = $this->repo::init($carShop)->update($data);
            return Redirect::route('car-shops.index')->with('alert', [
                'type' => 'success',
                'message' => 'CarShop Updated Successfully'
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
     * @param CarShop $carShop
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(DestroyCarShopRequest $request, CarShop $carShop)
    {
        $res = $this->repo::init($carShop)->destroy();
        if ($res) {
            return back()->with('alert', [
                'type' => 'success',
                'message' => "The CarShop was deleted successfully."
            ]);
        } else {
            return back()->with(['alert',
                'type' => 'error',
                'message' => "The CarShop could not be deleted."
            ]);
        }
    }

}
