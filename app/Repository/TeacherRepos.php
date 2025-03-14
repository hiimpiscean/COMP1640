<?php

namespace App\Repository;

use Illuminate\Support\Facades\DB;

class TeacherRepos
{
    public static function getAllTeacher() {
        $sql = "select t.*, 'teacher' as role ";
        $sql .= 'from teacher as t ';
        $sql .= 'order by t.email';

        return DB::select ($sql);
    }

    public static function getTeacherById($id_t){
        $sql = "select t.*, 'teacher' as role ";
        $sql .= 'from teacher as t ';
        $sql .= 'where t.id_t = ? ';

        return DB::select($sql, [$id_t]);
    }

    public static function insert($teacher){
        $sql = 'insert into teacher ';
        $sql .= '(fullname_t, phone_t, email, password)';
        $sql .= 'values(?, ?, ?, ?)';

        DB::insert($sql, [
            $teacher->fullname_t,
            $teacher->phone_t,
            $teacher->email,
            $teacher->password
        ]);
    }

    public static function update($teacher){
        $sql = 'update teacher ';
        $sql .= 'set fullname_t = ?, phone_t = ?, email = ?, password = ? ';
        $sql .= 'where id_t = ? ';

        DB::update($sql, [
            $teacher->fullname_t,
            $teacher->phone_t,
            $teacher->email,
            $teacher->password,
            $teacher->id_t]);
    }

    public static function delete($id_t){
        $sql = 'delete from teacher ';
        $sql .= "where id_t = ?";
        return DB::delete($sql, [$id_t]);
    }
}
