<?php

namespace App\Http\Controllers;

use App\Forms\UserForm;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Queries\UsersQueryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function __controller()
    {
        $this->middleware('auth:api', ['except' => ['show', 'index']]);
    }

    public function index(Request $request, UsersQueryInterface $usersQuery): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        $users = $usersQuery->setQuerySearch($request->query_search)
            ->setEmail($request->email)
            ->setName($request->name)
            ->execute($request->perPage, $request->page);

        return UserResource::collection($users);
    }

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

        return response()->json(['message' => trans('crud.user_created')], 200);
    }

    public function create(UserForm $form)
    {
        return response()->json(['form' => $form->get()]);
    }

    public function show(User $user): UserResource
    {
        return new UserResource($user->load('posts'));
    }

    public function update(Request $request, User $user): JsonResponse
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
                $assignedRoles->each(function ($assignedRole) use ($user) {
                    $user->removeRole($assignedRole);
                });
            }
            $user->assignRole($role);
        }

        return response()->json(['message' => trans('crud.user_updated')], 200);
    }

    public function edit(User $user, UserForm $form)
    {
        return response()->json(['form' => $form->fill($user)->get()]);
    }

    protected function destroy(User $user): JsonResponse
    {
        $user->delete();
        return response()->json(['message' => trans('crud.user_deleted')], 200);
    }
}
