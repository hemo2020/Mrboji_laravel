<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateUserRequest;
use App\Models\User;
use App\Services\Admin\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class UserController extends Controller
{
    public function __construct(public UserService $userService)
    {
    }
    public function index()
    {
        if(!Auth::user()->isAdmin()){
            return redirect()->route('admin.dashboard');
        }
        $data = User::query()
            ->where('role', '!=', User::ADMIN)
            ->get();
        return view('admin.user.list', compact('data'));
    }

    public function create($modal='no'): View
    {
        if ($modal == 'yes') {
            return view('admin.user.create_frm');
        }
        return view('admin.user.create');
    }

    public function save(CreateUserRequest $request): JsonResponse
    {
        $data = $request->validated();
        $data['password'] = Hash::make($data['password']);
        $this->userService->createUser($data);

        return response()->json(['message' => 'User created successfully', 'reload' => true], 200);
    }

    public function edit(User $user, $modal='no') : View
    {
        if ($modal == 'yes') {
            return view('admin.user.create_frm', compact('user'));
        }
        return view('admin.user.create', compact('user'));
    }

    public function update(User $user, CreateUserRequest $request): JsonResponse
    {
        $data = $request->validated();

        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $user->update($data);

        return response()->json(['message' => 'User updated successfully', 'redirectTo' => route('admin.users')], 200);
    }

    public function delete(User $user): JsonResponse
    {
        $user->delete();
        return response()->json(['message' => 'User deleted successfully!', 'reload' => true]);
    }

    public function getUserDropdown(Request $request): JsonResponse
    {
        $search = $request->get('search', '');

        $users = User::query()->select('id', 'name as text');

        if (!empty($search)) {
            $users->where(function($query) use($search) {
                $query->orWhere('name', 'like', '%' . $search . '%');
            });
        }

        if (!empty($request->role)) {
            $users->where('role', $request->role);
        }

        $users = $users->latest()->simplePaginate(200);

        $data['more'] = $users->hasMorePages();
        $data['results'] = $users->toArray()['data'];

        return response()->json($data, 200);
    }
}
