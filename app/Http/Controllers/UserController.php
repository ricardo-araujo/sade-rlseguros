<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function redefine(Request $request)
    {
        $this->validate($request, [
            'senha' => 'bail|required|confirmed|min:1',
        ]);

        $user = $request->user();

        $user->update(['password' => $request->get('senha')]);

        Auth::guard()->login($user);

        return response()->json(['success' => 'Senha alterada com sucesso!']);
    }
}
