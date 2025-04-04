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

    public static function insert($courseRegistration)
    {
        $sql = 'INSERT INTO course_registrations (teacher_id, course_id, status, created_at, description) VALUES (?, ?, ?, ?, ?)';

        $result = DB::insert($sql, [
            $courseRegistration->teacher_id,
            $courseRegistration->course_id,
            $courseRegistration->status,
            $courseRegistration->created_at,
            $courseRegistration->description
        ]);

        return $result ? DB::getPdo()->lastInsertId() : -1;
    }

    public static function update($courseRegistration)
    {
        $sql = 'UPDATE course_registrations SET teacher_id = ?, course_id = ?, status = ?, created_at = ?, description = ? WHERE id = ?';

        DB::update($sql, [
            $courseRegistration->teacher_id,
            $courseRegistration->course_id,
            $courseRegistration->status,
            $courseRegistration->created_at,
            $courseRegistration->description,
            $courseRegistration->id
        ]);
    }

    public static function delete($id)
    {
        $sql = 'DELETE FROM course_registrations WHERE id = ?';
        DB::delete($sql, [$id]);
    }
}
