<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ForcePasswordController extends Controller
{
    public function show()
    {
        return view('auth.force-password');
    }

    public function update(Request $request)
    {
        $request->validate(['password' => 'required|string|min:6|confirmed']);
        $user = auth()->user();
        $user->password = bcrypt($request->password);
        $user->must_change_password = false;
        $user->save();
        return redirect()->route('dashboard');
    }
}