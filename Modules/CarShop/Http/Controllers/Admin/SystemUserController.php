<?php

namespace Modules\CarShop\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Laravel\Jetstream\Role;
use Modules\CarShop\Entities\CarShop;
use Modules\CarShop\Http\Resources\CarShopResource;
use Modules\CarShop\Http\Resources\SystemUserResource;

class SystemUserController extends Controller
{
    public function index(Request $request)
    {
        $users = SystemUserResource::collection(
            User::query()
                ->when($request->input('search'), function ($query, $search) {
                    $query->where('name', 'like', '%' . $search . '%');
                })
                ->where('is_admin', 0)
                ->with('carShop')
                ->paginate(15)
                ->withQueryString()
        );

        return Inertia::render('@CarShop::Users/Index', [
            'filters' => $request->only('search'),
            'users' => $users,
        ]);
    }

    public function create()
    {
        $carShops = CarShopResource::collection(CarShop::all());

        return Inertia::render('@CarShop::Users/Create', [
            'carShops' => $carShops
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'phone' => 'required|min:10',
            'email' => 'required|email|unique:users,email',
            'userType' => 'required',
            'carShop' => 'required',
            'password' => 'required|min:6|confirmed',
            'is_active' => 'required|boolean',
        ]);

        try {

            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'user_type' => $validated['userType'],
                'car_shop_id' => $validated['carShop'],
                'phone' => $validated['phone'],
                'password' => bcrypt($validated['password']),
                'is_active' => $validated['is_active'],
            ]);

            $roles = false;

            if ($validated['userType'] == 1) {
                $user->assignRole(User::CAR_SHOP_ADMIN_ROLE);
            } else if ($validated['userType'] == 2) {
                $user->assignRole(User::SALES_ROLE);
            }

            return Redirect::route('system-users.index')->with('alert', [
                'type' => 'success',
                'message' => 'User Created Successfully',
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

    public function edit(Request $request, $id)
    {
        try {
            $user = User::findOrFail($id);
            $carShops = CarShopResource::collection(CarShop::all());
            return Inertia::render('@CarShop::Users/Edit', [
                'carShops' => $carShops,
                'model' => SystemUserResource::make($user)
            ]);
        } catch (\Throwable $exception) {
            \Log::error($exception);
            return back()->with('alert', [
                'type' => 'error',
                'message' => $exception->getMessage(),
            ]);
        }
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        if (!$request->password) {
            unset($request['password']);
        }



        $validated = $request->validate([
            'name' => 'required',
            'phone' => 'required|min:10|max:20',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'userType' => 'required',
            'car_shop_id' => 'required',
            'password' => 'sometimes|required|min:6|confirmed',
            'is_active' => 'sometimes|boolean',
        ]);

        $storedData = [
            'name' => $validated['name'],
            'phone' => $validated['phone'],
            'email' => $validated['email'],
            'user_type' => $validated['userType'],
            'car_shop_id' => $validated['car_shop_id'],
            'is_active' => $validated['is_active'],
        ];

        if ($request->password) {
            $storedData['password'] = bcrypt($validated['password']);
        }

        $user->update($storedData);

        $roles = false;

        if ($validated['userType'] == 1) {
            $user->syncRoles(User::CAR_SHOP_ADMIN_ROLE);
        } else if ($validated['userType'] == 2) {
            $user->syncRoles(User::SALES_ROLE);
        }


        return Redirect::route('system-users.index')->with('alert', [
            'type' => 'success',
            'message' => 'User Updated Successfully',
        ]);
    }

    public function destroy($id)
    {
        try {
            $user = User::findOrFail($id);
            $user->delete();
            return back()->with('alert', [
                'type' => 'success',
                'message' => 'User Deleted Successfully',
            ]);
        } catch (\Throwable $exception) {
            return back()->with([
                'alert' => [
                    'type' => 'error',
                    'message' => 'User Cannot Be Deleted',
                ]
            ]);
        }
    }

    public function getUserProfile($id)
    {
        abort_if(Auth::user()->id != $id, 403);

        try {
            $user = User::findOrFail($id);
            $carShops = CarShopResource::collection(CarShop::all());
            return Inertia::render('@CarShop::Users/Edit', [
                'carShops' => $carShops,
                'model' => SystemUserResource::make($user),
                'profile' => true,
            ]);
        } catch (\Throwable $exception) {
            \Log::error($exception);
            return back()->with('alert', [
                'type' => 'error',
                'message' => $exception->getMessage(),
            ]);
        }
    }

    public function postUserProfile(Request $request, $id)
    {
        abort_if(Auth::user()->id != $id, 403);

        $user = User::findOrFail($id);

        if (!$request->password) {
            unset($request['password']);
        }

        $validated = $request->validate([
            'name' => 'required',
            'phone' => 'required|min:10',
            'email' => 'required|email',
            'password' => 'sometimes|required|min:6|confirmed',
            'is_active' => 'sometimes|boolean',
        ]);

        $storedData = [
            'name' => $validated['name'],
            'phone' => $validated['phone'],
            'email' => $validated['email'],
            'is_active' => $validated['is_active'],
        ];

        if ($request->password) {
            $storedData['password'] = bcrypt($validated['password']);
        }

        $user->update($storedData);

        return Redirect::back()->with('alert', [
            'type' => 'success',
            'message' => 'User Updated Successfully',
        ]);
    }
}
