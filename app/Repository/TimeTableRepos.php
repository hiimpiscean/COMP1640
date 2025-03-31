<?php

namespace App\Repository;

use Illuminate\Support\Facades\DB;

class TimetableRepos
{
    public static function getAllTimetables()
    {
        $sql = 'SELECT t.* FROM timetable AS t ORDER BY t.day_of_week, t.start_time';
        return DB::select($sql);
    }

    public static function getTimetableById($id)
    {
        $sql = 'SELECT t.* FROM timetable AS t WHERE t.id = ?';
        return DB::select($sql, [$id]);
    }

    public static function insert($timetable)
    {
        $sql = 'INSERT INTO timetable (course_id, teacher_id, day_of_week, start_time, end_time, location, meet_link) ';
        $sql .= 'VALUES (?, ?, ?, ?, ?, ?, ?)';

        $result = DB::insert($sql, [
            $timetable->course_id,
            $timetable->teacher_id,
            $timetable->day_of_week,
            $timetable->start_time,
            $timetable->end_time,
            $timetable->location,
            $timetable->meet_link
        ]);

        return $result ? DB::getPdo()->lastInsertId() : -1;
    }

    public static function update($timetable)
    {
        $sql = 'UPDATE timetable ';
        $sql .= 'SET course_id = ?, teacher_id = ?, day_of_week = ?, start_time = ?, end_time = ?, location = ?, meet_link = ? ';
        $sql .= 'WHERE id = ?';

        DB::update($sql, [
            $timetable->course_id,
            $timetable->teacher_id,
            $timetable->day_of_week,
            $timetable->start_time,
            $timetable->end_time,
            $timetable->location,
            $timetable->meet_link,
            $timetable->id
        ]);
    }

    public static function delete($id)
    {
        $sql = 'DELETE FROM timetable WHERE id = ?';
        DB::delete($sql, [$id]);
    }
}
