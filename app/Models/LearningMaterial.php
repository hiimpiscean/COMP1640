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
            // Return default object if no teacher_id
            return (object) [
                'fullname_t' => 'Giáo viên #' . $this->teacher_id
            ];
        }

        $teacher = TeacherRepos::getTeacherById($this->teacher_id);
        if ($teacher) {
            return $teacher;
        } else {
            // Return default object if teacher not found
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