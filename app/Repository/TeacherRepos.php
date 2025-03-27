<?php

namespace App\Repository;

use Illuminate\Support\Facades\DB;

class TeacherRepos
{
    public static function getAllTeacher() {
        $sql = 'select t.* ';
        $sql .= 'from teacher as t ';
        $sql .= 'order by t.email_t';

        return DB::select ($sql);
    }

    public static function getTeacherById($id_t){
        $sql = 'select t.* ';
        $sql .= 'from teacher as t ';
        $sql .= 'where t.id_t = ? ';

        return DB::select($sql, [$id_t]);
    }

    public static function update($teacher){
        $sql = 'update teacher ';
        $sql .= 'set fullname_t = ?, phone_t = ?, email_t = ?, password = ? ';
        $sql .= 'where id_t = ? ';

        DB::update($sql, [
          //  $teacher->username,
            $teacher->fullname_t,
            $teacher->phone_t,
            $teacher->email_t,
            $teacher->password,
            $teacher->id_t]);

    }

}
