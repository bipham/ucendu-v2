<?php namespace App\Services;

use Illuminate\Support\Facades\File;

class ReadingImageService {
//    public function __construct()
//    {
//        $this->_readingLevelLessonModel = new ReadingPracticeLesson();
//    }

    public function saveImageToLocal($type_lesson_id, $img_name_no_ext, $img_url, $img_extension, $current_lesson_id) {
        $img_name_no_ext = stripUnicode($img_name_no_ext);
        $img_name_no_ext = str_replace(" ","_", $img_name_no_ext);
        $base_to_php = explode(',', $img_url);
        $data = base64_decode($base_to_php[1]);
        $img_name_save = $current_lesson_id . '-' . $img_name_no_ext . '.' . $img_extension;
        $filepath = base_path() . '\public\upload\img-feature\\' . $type_lesson_id;
        if (!File::exists($filepath)) {
            File::makeDirectory($filepath, 0777, true, true);
        }
        $filename_img = base_path() . '\public\upload\img-feature\\' . $type_lesson_id .'\\' . $img_name_save;
        file_put_contents($filename_img, $data);
        $destination = base_path() . '\public\upload\img-feature\\' . $type_lesson_id .'\\' . $img_name_save;
        compressImage($filename_img, $destination);
        return $img_name_save;
    }
}
?>