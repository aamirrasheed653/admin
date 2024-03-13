<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;

class AdminController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);
        $user = Admin::where('email', $request->email)->first();
        $invalid = $user == null || !Hash::check($request->password, $user->password);
        if ($invalid) {
            abort(401, 'Invalid User Email or Password');
        }
        $token = $user->createToken('AuthToken')->plainTextToken;
        $user['token'] = $token;
        return $user;
    }
}
