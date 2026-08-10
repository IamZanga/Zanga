<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ForcePasswordController extends Controller
{
    public function show()
    {
        return view('staff.auth.force-password');
    }

    public function update(Request $request)
    {
        $request->validate(['password' => 'required|string|min:6|confirmed']);

        $user = Auth::guard('staff')->user();
        $user->password = bcrypt($request->password);
        $user->must_change_password = false;
        $user->save();

        return redirect()->route($user->isAdmin() ? 'admin.dashboard' : 'teacher.dashboard');
    }
}
