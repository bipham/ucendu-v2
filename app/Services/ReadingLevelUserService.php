<?php namespace App\Services;

use App\Models\ReadingLevelUser;
use Illuminate\Support\Facades\Auth;

class ReadingLevelUserService {
    private $_readingLevelUserModel;
    private $_adminId;

    public function __construct()
    {
        $this->_readingLevelUserModel = new ReadingLevelUser();
        $this->_adminId = Auth::id();
    }

    public function createNewLevelUser($level) {
//        dd($this->_adminId);
        return $this->_readingLevelUserModel->createNewLevelUser($level, $this->_adminId);
    }

    public function getAllLevelUser() {
        return $this->_readingLevelUserModel->getAllLevelUser();
    }
}
?>