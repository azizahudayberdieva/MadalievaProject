<?php

namespace App\Http\Controllers;

use App\Forms\UserForm;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function __controller()
    {
        $this->middleware('auth:api', ['except' => ['show', 'index']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        return UserResource::collection(User::with('posts')->get());
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): JsonResponse
    {
        $attributes = $request->validate([
            'name' => 'required',
            'password' => 'required|min:3',
            'email' => 'required|email|unique:users'
        ]);

        $user = User::create($attributes);

        if ($request->role) {
            $role = Role::find($request->role);
            $user->assignRole($role);
        }

        return response()->json(['message' => 'Пользователь создан'], 200);
    }

    public function create(UserForm $form)
    {
        return response()->json(['form' => $form->get()]);
    }
    /**
     * Display the specified resource.
     *
     * @param User $user
     * @return UserResource
     */
    public function show(User $user): UserResource
    {
        return new UserResource($user->load('posts'));
    }

    /**
     * Update the specified resource in storage.
     *
     *
     * @param \Illuminate\Http\Request $request
     * @param User $user
     * @return JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, User $user) : JsonResponse
    {
        $attributes = $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email'
        ]);

        $user->fill($attributes)->save();

        if ($request->role) {
            $role = Role::find($request->role);
            $assignedRoles = $user->roles;

            if ($assignedRoles) {
                $assignedRoles->each(function($assignedRole) use ($user){
                    $user->removeRole($assignedRole);
                });
            }
            $user->assignRole($role);
        }

        return response()->json(['message' => 'Пользователь обновлен'], 200);
    }

    public function edit(User $user, UserForm $form)
    {
        return response()->json(['form' => $form->fill($user)->get()]);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    protected function destroy(User $user): JsonResponse
    {
        $user->delete();
        return response()->json(['message' => 'Пользоваетль удален'],200);
    }
}
