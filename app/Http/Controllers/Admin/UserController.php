<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\RegisterRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Services\ReadingLevelUserService;
use App\Services\UcenduUserService;

class UserController extends Controller
{
    use RegistersUsers;
    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    public function getCreateNewUser($domain) {
        $readingLevelUserService = new ReadingLevelUserService();
        $all_level_users = $readingLevelUserService->getAllLevelUser();
        return view('admin.createNewUser', compact('all_level_users'));
    }

    public function postCreateNewUser($domain, RegisterRequest $request) {
        //Get parameters:
        $username = $request->username;
        $email = $request->email;
        $password = Hash::make('abc123');;
        $level_user_id = $request->level;
        $avatar = 'default.jpg';
        $remember_token = $request->_token;
        $ucenduUserService = new UcenduUserService();
        $result = $ucenduUserService->createNewUser($username, $email, $password, $level_user_id, $avatar, $remember_token);
        if ($result) {
            $message = ['flash_level'=>'success message-custom','flash_message'=>'Đăng ký thành công!'];
            return redirect('createNewUser')->with($message);
        }
    }
}
