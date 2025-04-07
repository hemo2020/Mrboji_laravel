<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileUpdateRequest;
use App\Models\User;
use App\Services\Admin\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function __construct(public UserService $userService)
    {
    }
    public function edit(Request $request): View
    {
        return view('admin.profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the customer's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('admin.profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the customer's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current-password'],
        ]);

        $user = $request->user();
        Auth::logout();
        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::route('admin.dashboard');
    }

    public function getUserDropdown(Request $request): JsonResponse
    {
        $user = Auth::user();
        $status = $request->get('status', 1);
        $search = $request->get('search', '');
        $role = $request->get('role', '');

        $users = User::select('id', 'name as text');

        if (!empty($user)) {
            $users->where('id', '!=', $user->id);
        }

        if (!empty($search)) {
            $users->where('name', 'like', '%' . $search . '%');
        }

        if (!empty($status)) {
            $users->where('status', $status);
        }

        if (!empty($role)) {
            if (is_array($role)) {
                $users->whereIn('role', $role);
            } else {
                $users->where('role', $role);
            }
        }

        $users = $users->latest()->simplePaginate(200);

        $data['more']    = $users->hasMorePages();
        $data['results'] = $users->toArray()['data'];

        return response()->json($data, 200);
    }
}
