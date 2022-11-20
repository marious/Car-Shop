<?php

namespace Modules\Insurance\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Modules\Insurance\Http\Requests\Price\IndexPriceRequest;
use Modules\Insurance\Http\Requests\Price\StorePriceRequest;
use Modules\Insurance\Http\Requests\Price\UpdatePriceRequest;
use Modules\Insurance\Http\Requests\Price\DestroyPriceRequest;
use Illuminate\Support\Facades\Redirect;
use Modules\Insurance\Http\Resources\Inertia\PriceResource;
use Modules\Insurance\Entities\Price;
use Modules\Insurance\Repositories\PriceRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;

class PriceController extends Controller
{
    private PriceRepository $repo;

    public function __construct(PriceRepository $repo)
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
        $this->authorize('viewAny', Price::class);
        $prices = PriceResource::collection(
            Price::query()
                ->when($request->input('search'), function ($query, $search) {
                    $query->whereRaw('LOWER(JSON_EXTRACT(name, "$.en")) like ?', ['"%' . strtolower($search) . '%"'])
                        ->orWhereRaw('LOWER(JSON_EXTRACT(name, "$.ar")) like ?', ['"%' . strtolower($search) . '%"']);
                })
                ->paginate(15)
                ->withQueryString()
        );
        return Inertia::render('@Insurance::Prices/Index', [
            "can" => [
                "viewAny" => \Auth::user()->can('viewAny', Price::class),
                "create" => \Auth::user()->can('create', Price::class),
            ],
            'filters' => $request->only('search'),
            "prices" => $prices,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Inertia\Response
     */
    public function create()
    {
        $this->authorize('create', Price::class);
        return Inertia::render("@Insurance::Prices/Create", [
            "can" => [
                "viewAny" => \Auth::user()->can('viewAny', Price::class),
                "create" => \Auth::user()->can('create', Price::class),
            ]
        ]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param StorePrice $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StorePriceRequest $request)
    {
        try {
            $data = $request->sanitizedObject();
            $price = $this->repo::store($data);
            return Redirect::route('prices.index')->with('alert', [
                'type' => 'success',
                'message' => 'Price Created Successfully'
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
     * @param Price $price
     * @return \Inertia\Response|\Illuminate\Http\RedirectResponse
     */
    public function show(Request $request, Price $price)
    {
        try {
            $this->authorize('view', $price);
            $model = $this->repo::init($price)->show($request);
            return Inertia::render("Prices/Show", ["model" => $model]);
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
     * @param Price $price
     * @return \Inertia\Response|\Illuminate\Http\RedirectResponse
     */
    public function edit(Request $request, Price $price)
    {
        try {
            $this->authorize('update', $price);
            //Fetch relationships


            return Inertia::render("@Insurance::Prices/Edit", ["model" => $price]);
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
     * @param UpdatePrice $request
     * @param {$modelBaseName} $price
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdatePriceRequest $request, Price $price)
    {
        try {
            $data = $request->sanitizedObject();
            $res = $this->repo::init($price)->update($data);
            return Redirect::route('prices.index')->with('alert', [
                'type' => 'success',
                'message' => 'Price Updated Successfully'
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
     * @param Price $price
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(DestroyPriceRequest $request, Price $price)
    {
        $res = $this->repo::init($price)->destroy();
        if ($res) {
            return back()->with('alert', [
                'type' => 'success',
                'message' => "The Price was deleted successfully."
            ]);
        } else {
            return back()->with(['alert',
                'type' => 'error',
                'message' => "The Price could not be deleted."
            ]);
        }
    }

}
