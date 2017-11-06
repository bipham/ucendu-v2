<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use App\Services\ReadingLevelLessonService;

class ReadingLevelLessonController extends Controller
{
    public function getCreateNewLevelLesson($domain) {
        return view('admin.readingCreateNewLevelLesson');
    }

    public function postCreateNewLevelLesson($domain) {
        $readingLevelLessonService = new ReadingLevelLessonService();
        $level = Input::get('level');
        $result = $readingLevelLessonService->createNewLevelLesson($level);
        if ($result == 'success') {
            $message = ['flash_level'=>'success message-custom','flash_message'=>'Tạo level lesson thành công!'];
        }
        else {
            $message = ['flash_level'=>'danger message-custom','flash_message'=>'Level lesson này đã tồn tại!'];
        }
        return redirect('createNewLevelLesson')->with($message);
    }
}
