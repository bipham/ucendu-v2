<?php namespace App\Services;

use App\User;
use Illuminate\Support\Facades\Auth;

class UcenduUserService
{
    private $_readingUserModel;
    private $_adminId;

    public function __construct()
    {
        $this->_readingUserModel = new User();
        $this->_adminId = Auth::id();
    }

    public function createNewUser($username, $email, $password, $level_user_id, $avatar, $remember_token)
    {
        return $this->_readingUserModel->createNewUser($username, $email, $password, $level_user_id, $avatar, $remember_token, $this->_adminId);
    }

    public function updateNewPasswordOfUser($new_password) {
        return $this->_readingUserModel->updateNewPasswordOfUser($new_password, $this->_adminId);
    }

    public function getLevelCurrentUser() {
        return $this->_readingUserModel->getLevelCurrentUser($this->_adminId);
    }

    public function getAllAdmins() {
        $all_admins = $this->_readingUserModel->getAllAdmins();
        foreach ($all_admins as $index => $admin) {
            $all_admins[$index]->user_id = $admin->id;
        }
        return $all_admins;
    }
}
?>