<?php

namespace App\Repository;

use Illuminate\Support\Facades\DB;
use App\Models\Timetable;
use Exception;
use Illuminate\Support\Facades\Log;

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
     * Lấy danh sách sản phẩm
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
        return Timetable::findOrFail($id);
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
        try {
            Log::info('Cập nhật Google Meet link cho lịch học', [
                'timetable_id' => $id,
                'meet_link' => $meetLink
            ]);

            $result = DB::table('timetable')
                ->where('id', $id)
                ->update(['meet_link' => $meetLink]);

            return $result;
        } catch (\Exception $e) {
            Log::error('Lỗi khi cập nhật Google Meet link: ' . $e->getMessage(), [
                'timetable_id' => $id,
                'exception' => $e->getTraceAsString()
            ]);
            throw $e;
        }
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
     * Lấy thông tin sản phẩm
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

    /**
     * Lấy danh sách lịch học công khai cho trang schedule
     */
    public function getPublicTimetables()
    {
        $timetables = DB::table('timetable')
            ->select(
                'timetable.*',
                'product.name_p as course_name',
                'teacher.fullname_t as teacher_name'
            )
            ->join('product', 'timetable.course_id', '=', 'product.id_p')
            ->join('teacher', 'timetable.teacher_id', '=', 'teacher.id_t')
            ->orderBy('timetable.day_of_week')
            ->orderBy('timetable.start_time')
            ->get();

        return $timetables;
    }

    /**
     * Tự động gán học sinh đã đăng ký vào thời khóa biểu sau khi tạo thời khóa biểu mới
     * 
     * @param int $timetableId
     * @param int $courseId
     * @return bool
     */
    public function assignStudentToTimetable($timetableId, $courseId)
    {
        try {
            // Lấy danh sách học sinh đã được phê duyệt nhưng chưa được gán vào thời khóa biểu
            $pendingRegistrations = DB::table('course_registrations')
                ->where('course_id', $courseId)
                ->where('status', 'approved')
                ->whereNull('timetable_id')
                ->get();

            // Nếu không có học sinh nào, trả về true (không cần thực hiện thêm)
            if (count($pendingRegistrations) == 0) {
                return true;
            }

            // Gán học sinh vào thời khóa biểu
            foreach ($pendingRegistrations as $registration) {
                DB::table('course_registrations')
                    ->where('id', $registration->id)
                    ->update(['timetable_id' => $timetableId]);
            }

            return true;
        } catch (\Exception $e) {
            Log::error('Lỗi khi gán học sinh vào thời khóa biểu: ' . $e->getMessage());
            return false;
        }
    }
}
