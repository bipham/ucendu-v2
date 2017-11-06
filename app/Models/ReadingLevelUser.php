<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReadingLevelUser extends Model
{
    protected $table = 'reading_level_users';

    protected $fillable = ['level', 'admin_responsibility', 'status'];

    public $timestamps = true;

    public function practiceLessons()
    {
        return $this->hasMany('App\Models\ReadingPracticeLesson', 'level_user_id');
    }

    public function createNewLevelUser($level, $admin_responsibility) {

        if ($this->where('level', '=', $level)->exists()) {
            // level found
            return 'fail';
        }
        else {
            $new_level_user = new ReadingLevelUser();
            $new_level_user->level = $level;
            $new_level_user->admin_responsibility = $admin_responsibility;
            $new_level_user->save();
            return 'success';
        }
    }

    public function getAllLevelUser() {
        return $this->where('status', 1)->get();
    }
}
