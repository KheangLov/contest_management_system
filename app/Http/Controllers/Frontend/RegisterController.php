<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class RegisterController extends Controller
{
    public function formRegister()
    {
        return view('frontend.register');
    }

    public function create(Request $request)
    {
        Session::put('actionAuthFront', 'register');
        Session::put('frontend_login_popup', 'register');
        $userModelFqn = config('backpack.base.user_model_fqn');
        $user = new $userModelFqn();

        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:4', 'confirmed'],
        ]);

        $name = trim($request->first_name) . trim($request->last_name);
        if ($user->CheckNameExist($name)->count()) {
            $name .= $user->CheckNameExist($name)->count();
        }

        $userAfter = $user->create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'name' => $name,
            'phone' => $request->phone,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'status' => 'active',
        ]);
        if ($request->role) {
            $userAfter->roles()->syncWithoutDetaching([$request->role]);

            if ($request->role == 3) {
                $userAfter->login_token = Hash::make($request->email . $request->password);
                $userAfter->update();
            }
        }

        if ($userAfter) {
            Auth::login($userAfter, true);
            if ($request->workshop_id) {
                $userAfter->workshopJoiners()->syncWithoutDetaching([$request->workshop_id]);
            }
            return redirect()->route('workshop');
        }
    }
}
