<?php

namespace App\Repository;

use Illuminate\Support\Facades\DB;
use App\Models\Timetable;
use Exception;

class TimetableRepos
{
    /**
     * Lấy tất cả lịch học
     */
    public function getAllTimetables()
    {
        return Timetable::all();
    }

    /**
     * Lấy danh sách khóa học
     */
    public function getCourses()
    {
        return DB::table('product')
            ->select('id_p as course_id', 'name_p as course_name')
            ->get();
    }

    /**
     * Lấy danh sách giảng viên
     */
    public function getTeachers()
    {
        return DB::table('teacher')
            ->select('id_t', 'fullname_t')
            ->get();
    }

    /**
     * Lấy thông tin lịch học theo ID
     */
    public function getTimetableById($id)
    {
        return Timetable::with(['course', 'teacher'])->findOrFail($id);
    }

    /**
     * Tạo lịch học mới
     */
    public function create($data)
    {
        $id = DB::select(
            "INSERT INTO timetable (course_id, teacher_id, day_of_week, start_time, end_time, location) 
             VALUES (?, ?, ?, ?, ?, ?) RETURNING id",
            [
                $data['course_id'],
                $data['teacher_id'],
                $data['day_of_week'],
                $data['start_time'],
                $data['end_time'],
                $data['location']
            ]
        );

        return $id[0]->id;
    }

    /**
     * Cập nhật meet link cho lịch học
     */
    public function updateMeetLink($id, $meetLink)
    {
        return DB::table('timetable')
            ->where('id', $id)
            ->update(['meet_link' => $meetLink]);
    }

    /**
     * Lấy location của lịch học
     */
    public function getLocation($id)
    {
        return DB::table('timetable')
            ->where('id', $id)
            ->value('location');
    }

    /**
     * Cập nhật thông tin lịch học
     */
    public function update($id, $data)
    {
        return DB::table('timetable')
            ->where('id', $id)
            ->update([
                'course_id' => $data['course_id'],
                'teacher_id' => $data['teacher_id'],
                'day_of_week' => $data['day_of_week'],
                'start_time' => $data['start_time'],
                'end_time' => $data['end_time'],
                'location' => $data['location'],
                'meet_link' => $data['meet_link'] ?? null,
            ]);
    }

    /**
     * Xóa lịch học
     */
    public function delete($id)
    {
        return Timetable::findOrFail($id)->delete();
    }

    /**
     * Lấy tất cả lịch học của một khóa học
     */
    public function getTimetablesByCourseId($courseId)
    {
        return DB::table('timetable')
            ->where('course_id', $courseId)
            ->get();
    }

    /**
     * Lấy thông tin khóa học
     */
    public function getCourseById($courseId)
    {
        return DB::table('product')
            ->where('id_p', $courseId)
            ->first();
    }

    /**
     * Lấy thông tin giảng viên
     */
    public function getTeacherById($teacherId)
    {
        return DB::table('teacher')
            ->where('id_t', $teacherId)
            ->first();
    }
}
