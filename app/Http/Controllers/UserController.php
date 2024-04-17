<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserCrudResource;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): \Inertia\Response|\Inertia\ResponseFactory
    {
        $query = User::query();

        $sortField = request("sort_field", 'created_at');
        $sortDirection = request("sort_direction", "desc");

        if (request("name")) {
            $query->where("name", "like", "%" . request("name") . "%");
        }
        if (request("email")) {
            $query->where("email", "like", "%" . request("email") . "%");
        }

        $users = $query->orderBy($sortField, $sortDirection)
            ->paginate(10)
            ->onEachSide(1);
        $currentPage = $users->currentPage();
        return inertia("User/Index", [
            "users" => UserCrudResource::collection($users),
            'queryParams' => request()->query() ?: null,
            'success' => session('success'),
            'currentPage' => $currentPage
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): \Inertia\Response|\Inertia\ResponseFactory
    {
        return inertia("User/Create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request): \Illuminate\Http\RedirectResponse
    {
        $data = $request->validated();
        $data['email_verified_at'] = time();
        $data['password'] = bcrypt($data['password']);
        $avatar = $data['avatar'] ?? null;

        if ($avatar) {
            $data['avatar_path'] = $avatar->store('user/' . Str::random(), 'public');
        }

        User::create($data);

        return to_route('user.index')
            ->with('success', 'User was created');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user): \Inertia\Response|\Inertia\ResponseFactory
    {
        return inertia('User/Show', [
            'user' => new UserResource($user),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user): \Inertia\Response|\Inertia\ResponseFactory
    {
        return inertia('User/Edit', [
            'user' => new UserCrudResource($user),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user): \Illuminate\Http\RedirectResponse
    {
        $data = $request->validated();
        $avatar = $data['avatar'] ?? null;
        $password = $data['password'] ?? null;
        if ($password) {
            $data['password'] = bcrypt($password);
        } else {
            unset($data['password']);
        }
        if ($avatar) {
            if ($user->avatar_path) {
                Storage::disk('public')->deleteDirectory(dirname($user->avatar_path));
            }
            $data['avatar_path'] = $avatar->store('project/' . Str::random(), 'public');
        }
        $user->update($data);

        return to_route('user.index')
            ->with('success', "User \"$user->name\" was updated");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user): \Illuminate\Http\RedirectResponse
    {
        $name = $user->name;
        $user->delete();
        if ($user->avatar_path) {
            Storage::disk('public')->deleteDirectory(dirname($user->avatar_path));
        }
        return to_route('user.index')
            ->with('success', "User \"$name\" was deleted");
    }
}
