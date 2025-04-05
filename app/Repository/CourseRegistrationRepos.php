<?php

namespace App\Repository;

use Illuminate\Support\Facades\DB;

class CourseRegistrationRepos
{
    public static function getAll()
    {
        $sql = 'SELECT cr.* FROM course_registrations AS cr ORDER BY cr.id';
        return DB::select($sql);
    }

    public static function getById($id)
    {
        $sql = 'SELECT cr.* FROM course_registrations AS cr WHERE cr.id = ?';
        return DB::select($sql, [$id]);
    }

    /**
     * Get all registrations for a specific course
     *
     * @param int $courseId
     * @return array
     */
    public static function getByCourseId($courseId)
    {
        $sql = 'SELECT cr.* FROM course_registrations AS cr WHERE cr.course_id = ? ORDER BY cr.created_at DESC';
        return DB::select($sql, [$courseId]);
    }

    /**
     * Get all registrations with a specific status
     *
     * @param string $status
     * @return array
     */
    public static function getByStatus($status)
    {
        $sql = 'SELECT cr.* FROM course_registrations AS cr WHERE cr.status = ? ORDER BY cr.created_at DESC';
        return DB::select($sql, [$status]);
    }

    /**
     * Get all registrations for a specific student
     *
     * @param int $studentId
     * @return array
     */
    public static function getByStudentId($studentId)
    {
        $sql = 'SELECT cr.* FROM course_registrations AS cr WHERE cr.id = ? ORDER BY cr.created_at DESC';
        return DB::select($sql, [$studentId]);
    }

    /**
     * Get all registrations for a specific teacher
     *
     * @param int $teacherId
     * @return array
     */
    public static function getByTeacherId($teacherId)
    {
        $sql = 'SELECT cr.* FROM course_registrations AS cr WHERE cr.teacher_id = ? ORDER BY cr.created_at DESC';
        return DB::select($sql, [$teacherId]);
    }

    /**
     * Get registration by student and course
     *
     * @param int $studentId
     * @param int $courseId ID của khóa học (product.id_p)
     * @return array
     */
    public static function getByStudentAndCourse($studentId, $courseId)
    {
        // LƯU Ý: course_id trong bảng course_registrations tham chiếu đến product.id_p
        // KHÔNG phải timetable.id như comment cũ
        // Lọc cả studentId, kiểm tra trong trường description
        $sql = 'SELECT cr.* FROM course_registrations AS cr 
                WHERE cr.course_id = ?
                AND cr.description LIKE ?
                AND cr.status IN (\'pending\', \'approved\')';
        return DB::select($sql, [$courseId, 'Student ID: ' . $studentId . '%']);
    }

    public static function insert($courseRegistration)
    {
        // QUAN TRỌNG: Bảng course_registrations có ràng buộc NOT NULL trên các cột sau
        // - teacher_id: Không được NULL
        // - course_id: Không được NULL
        // - status: Không được NULL
        // - created_at: Không được NULL
        $sql = 'INSERT INTO course_registrations (teacher_id, course_id, status, created_at, description) 
                VALUES (?, ?, ?, ?, ?)';

        // Đảm bảo tất cả các giá trị đều không null cho các cột có ràng buộc NOT NULL
        $result = DB::insert($sql, [
            $courseRegistration->teacher_id, // Phải đảm bảo đây không phải là null
            $courseRegistration->course_id,
            $courseRegistration->status,
            $courseRegistration->created_at,
            $courseRegistration->description ?? ''  // Dùng chuỗi rỗng thay vì null
        ]);

        return $result ? DB::getPdo()->lastInsertId() : -1;
    }

    public static function update($courseRegistration)
    {
        // QUAN TRỌNG: Đảm bảo không cập nhật NULL vào các cột có ràng buộc NOT NULL
        $sql = 'UPDATE course_registrations 
                SET teacher_id = ?, 
                    course_id = ?, 
                    status = ?, 
                    created_at = ?, 
                    description = ?
                WHERE id = ?';

        $result = DB::update($sql, [
            $courseRegistration->teacher_id ?? 1, // Đảm bảo không NULL
            $courseRegistration->course_id,
            $courseRegistration->status,
            $courseRegistration->created_at,
            $courseRegistration->description ?? '',
            $courseRegistration->id
        ]);
        
        return $result > 0; // Trả về true nếu có ít nhất 1 dòng được cập nhật
    }

    public static function delete($id)
    {
        $sql = 'DELETE FROM course_registrations WHERE id = ?';
        DB::delete($sql, [$id]);
    }
}
