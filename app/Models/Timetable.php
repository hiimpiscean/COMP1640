<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Teacher;

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

    // Loại bỏ relationships để tránh lỗi class not found
    // Thay vào đó sử dụng repository pattern để lấy dữ liệu
}