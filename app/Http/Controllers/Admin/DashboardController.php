<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cases;
use App\Models\FinancialYear;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Models\Car;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(): View
    {
        $authUser = Auth::user();
        $cars = Car::query()->count();
        $users = User::query()->count();
        $cases = Cases::query();

        if ($authUser->isWriter()) {
            $cases->where('created_by', $authUser->id);
        }

        if ($authUser->isPricing()) {
            $cases->where('assigned_to', $authUser->id);
        }

        $cases = $cases->count();


        return view('admin.dashboard', compact(['cars', 'users', 'cases', 'authUser']));
    }

    public function loadNotifications()
    {
        $notifications = Auth::user()->unreadNotifications;
        $html = view('components.notification-list', compact('notifications'))->render();
        $count = count($notifications);

        return response()->json(['html' => $html, 'count' => $count]);
    }
}
