<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Repository\TeacherRepos;

class LearningMaterial extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'file_path', 'teacher_id', 'status', 'product_id'];

    protected $appends = ['teacher_data'];

    public function getTeacherDataAttribute()
    {
        if (!$this->teacher_id) {
            // Trả về đối tượng mặc định nếu không có teacher_id
            return (object) [
                'fullname_t' => 'Giáo viên #' . $this->teacher_id
            ];
        }

        $teacher = TeacherRepos::getTeacherById($this->teacher_id);
        if ($teacher && isset($teacher->fullname_t)) {
            return $teacher;
        } else {
            // Trả về đối tượng mặc định nếu không tìm thấy giáo viên
            return (object) [
                'fullname_t' => 'Giáo viên #' . $this->teacher_id
            ];
        }
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }
}