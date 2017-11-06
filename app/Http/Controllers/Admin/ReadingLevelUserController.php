<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use App\Services\ReadingLevelUserService;

class ReadingLevelUserController extends Controller
{
    public function getCreateNewLevelUser($domain) {
        return view('admin.readingCreateNewLevelUser');
    }

    public function postCreateNewLevelUser($domain) {
        $readingLevelLessonService = new ReadingLevelUserService();
        $level = Input::get('level');
        $result = $readingLevelLessonService->createNewLevelUser($level);
        if ($result == 'success') {
            $message = ['flash_level'=>'success message-custom','flash_message'=>'Tạo level user thành công!'];
        }
        else {
            $message = ['flash_level'=>'danger message-custom','flash_message'=>'Level user này đã tồn tại!'];
        }

        return redirect('createNewLevelUser')->with($message);
    }
}
