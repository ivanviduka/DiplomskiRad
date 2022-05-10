<?php

namespace App\Http\Controllers;

use App\Actions\DatabaseAction;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $users = User::select('id', 'first_name', 'last_name', 'email', 'is_admin')->with('files')
            ->orderBy('is_admin', 'DESC')
            ->orderBy('last_name', 'ASC')
            ->paginate(10);

        return view('admin.admin-homepage', [
            'users' => $users,
        ]);

    }

    public function statistics(DatabaseAction $action)
    {
        return view('admin.statistics', [
            'statistics' => $action->adminStatistics()
        ]);
    }

    public function changeRole(User $user, Request $request)
    {
        $request->validate([
            'role_id' => 'required|in:0,1',
        ]);

        $user->update([
            'is_admin' => $request->role_id
        ]);

        return redirect()->route('admin');
    }

}
