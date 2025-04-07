<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;


class Timetable extends Model
{
    use HasFactory;

    // Chỉ định tên bảng chính xác trong cơ sở dữ liệu
    protected $table = 'timetable';
    
    // Tắt tính năng timestamps vì bảng không có các cột created_at và updated_at
    public $timestamps = false;

    protected $fillable = [
        'course_id',
        'teacher_id',
        'day_of_week',
        'start_time',
        'end_time',
        'location',
        'meet_link'
    ];

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }
}
