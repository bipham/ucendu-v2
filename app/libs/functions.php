<?php
/**
 * Created by PhpStorm.
 * User: BiPham
 * Date: 7/16/2017
 * Time: 4:16 PM
 */
function stripUnicode($str) {
    if (!$str) {
        return $str;
    }
    else {
        $unicode = array(
            'a' => 'á|à|ả|ã|ạ|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ',
            'A' => 'Á|À|Ả|Ã|Ạ|Ă|Ắ|Ằ|Ẳ|Ẵ|Ặ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ',
            'd' => 'đ',
            'D' => 'Đ',
            'e' => 'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ',
            'E' => 'É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ',
            'i' => 'í|ì|ỉ|ĩ|ị',
            'I' => 'Í|Ì|Ỉ|Ĩ|Ị',
            'o' => 'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ',
            'O' => 'Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Õ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ',
            'u' => 'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự',
            'U' => 'Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự',
            'y' => 'ý|ỳ|ỷ|ỹ|ỵ',
            'Y' => 'Ý|Ỳ|Ỷ|Ỹ|Ỵ'
        );
        foreach($unicode as $khongdau=>$codau) {
            $arr = explode("|",$codau);
            $str = str_replace($arr,$khongdau,$str);
        }
        return $str;
    }
}

function getIdFromLink ($str) {
    preg_match_all('/\d+/', $str, $matches);
    return $matches[0][0];
}

function timeago($date) {
    $timestamp = strtotime($date);

    $strTime = array("giây", "phút", "giờ");
    $length = array("60","60","24");

    $currentTime = time();
    if($currentTime >= $timestamp) {
        $diff     = time()- $timestamp;
        for($i = 0; $diff >= $length[$i] && $i < count($length)-1; $i++) {
            $diff = $diff / $length[$i];
        }

        $diff = round($diff);

        if ($diff > 24) {
            return date("d M Y",$timestamp);
        }
        return $diff . " " . $strTime[$i] . " trước";
    }
}

function timeFormat($date) {
    $date = \Carbon\Carbon::parse($date);

    $timestamp = strtotime($date);

    $humanTime = '';

    if($date->isToday())
    {
        if($date->diffInHours() < 1)
        {
            $humanTime = $date->diffInMinutes().' minutes ago';
        }
        else{
            $humanTime = $date->format('H:i').' today';
        }
    }
    else if($date->isYesterday())
    {
        $humanTime = $date->format('H:i').' yesterday';
    }
    else{
        $humanTime = date("d M Y",$timestamp);
    }

    return $humanTime;
}

function compressImage ($source_url, $destination_url, $quality = 75) {
    $info = getimagesize($source_url);

    if ($info['mime'] == 'image/jpeg')
        $image = imagecreatefromjpeg($source_url);

    elseif ($info['mime'] == 'image/gif')
        $image = imagecreatefromgif($source_url);

    elseif ($info['mime'] == 'image/png')
        $image = imagecreatefrompng($source_url);

    imagejpeg($image, $destination_url, $quality);
}

function checkAnswerByIdCustom($answer_key, $answer_extractly) {
    $answer_key = trim($answer_key);
    $answer_solution = trim($answer_extractly);
    if (strpos($answer_solution, '//') !== false) {
        $array_solution = explode("//", $answer_solution);
        foreach ($array_solution as $or_solution) {
            $or_solution = trim($or_solution);
            if (strtolower($or_solution) == strtolower(urldecode($answer_key))) {
                return true;
            }
        }
    }
    elseif (strtolower($answer_solution) == strtolower(urldecode($answer_key))) {
        return true;
    }
    else return false;
}

?>