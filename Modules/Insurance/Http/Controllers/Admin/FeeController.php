<?php

namespace Modules\Insurance\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Modules\Insurance\Http\Requests\Fee\IndexFeeRequest;
use Modules\Insurance\Http\Requests\Fee\StoreFeeRequest;
use Modules\Insurance\Http\Requests\Fee\UpdateFeeRequest;
use Modules\Insurance\Http\Requests\Fee\DestroyFeeRequest;
use Illuminate\Support\Facades\Redirect;
use Modules\Insurance\Http\Resources\Inertia\FeeResource;
use Modules\Insurance\Entities\Fee;
use Modules\Insurance\Repositories\FeeRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;

class FeeController extends Controller
{
    private FeeRepository $repo;

    public function __construct(FeeRepository $repo)
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
        $this->authorize('viewAny', Fee::class);
        $fees = FeeResource::collection(
            Fee::query()
                ->when($request->input('search'), function ($query, $search) {
                    $query->whereRaw('LOWER(JSON_EXTRACT(name, "$.en")) like ?', ['"%' . strtolower($search) . '%"'])
                        ->orWhereRaw('LOWER(JSON_EXTRACT(name, "$.ar")) like ?', ['"%' . strtolower($search) . '%"']);
                })
                ->paginate(15)
                ->withQueryString()
        );
        return Inertia::render('@Insurance::Fees/Index', [
            "can" => [
                "viewAny" => \Auth::user()->can('viewAny', Fee::class),
                "create" => \Auth::user()->can('create', Fee::class),
            ],
            'filters' => $request->only('search'),
            "fees" => $fees,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Inertia\Response
     */
    public function create()
    {
        $this->authorize('create', Fee::class);
        return Inertia::render("@Insurance::Fees/Create", [
            "can" => [
                "viewAny" => \Auth::user()->can('viewAny', Fee::class),
                "create" => \Auth::user()->can('create', Fee::class),
            ]
        ]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param StoreFee $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreFeeRequest $request)
    {
        try {
            $data = $request->sanitizedObject();
            $fee = $this->repo::store($data);
            return Redirect::route('fees.index')->with('alert', [
                'type' => 'success',
                'message' => 'Fee Created Successfully'
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
     * @param Fee $fee
     * @return \Inertia\Response|\Illuminate\Http\RedirectResponse
     */
    public function show(Request $request, Fee $fee)
    {
        try {
            $this->authorize('view', $fee);
            $model = $this->repo::init($fee)->show($request);
            return Inertia::render("Fees/Show", ["model" => $model]);
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
     * @param Fee $fee
     * @return \Inertia\Response|\Illuminate\Http\RedirectResponse
     */
    public function edit(Request $request, Fee $fee)
    {
        try {
            $this->authorize('update', $fee);
            //Fetch relationships


            return Inertia::render("@Insurance::Fees/Edit", ["model" => $fee]);
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
     * @param UpdateFee $request
     * @param {$modelBaseName} $fee
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateFeeRequest $request, Fee $fee)
    {
        try {
            $data = $request->sanitizedObject();
            $res = $this->repo::init($fee)->update($data);
            return Redirect::route('fees.index')->with('alert', [
                'type' => 'success',
                'message' => 'Fee Updated Successfully'
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
     * @param Fee $fee
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(DestroyFeeRequest $request, Fee $fee)
    {
        $res = $this->repo::init($fee)->destroy();
        if ($res) {
            return back()->with('alert', [
                'type' => 'success',
                'message' => "The Fee was deleted successfully."
            ]);
        } else {
            return back()->with(['alert',
                'type' => 'error',
                'message' => "The Fee could not be deleted."
            ]);
        }
    }

}
