<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\UcenduUserService;

class UserController extends Controller
{
    public function getChangePassword () {
        return view('auth.changePassword');
    }

    public function postChangePassword (Request $request) {
        $ucenduUserService = new UcenduUserService();
        $new_password = $request->password;
        $ucenduUserService->updateNewPasswordOfUser($new_password);
        return redirect()->intended('/');
    }
}
