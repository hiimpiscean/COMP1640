<?php

namespace App\Repository;

use Illuminate\Support\Facades\DB;

class StudentRepos
{
    public static function getAllStudent() {
        $sql = 'select s.* ';
        $sql .= 'from student as s ';
        $sql .= 'order by s.email_s';

        return DB::select ($sql);
    }

    public static function getStudentById($id_s){
        $sql = 'select s.* ';
        $sql .= 'from student as s ';
        $sql .= 'where s.id_s = ? ';

        return DB::select($sql, [$id_s]);
    }

    public static function update($student){
        $sql = 'update student ';
        $sql .= 'set fullname_s = ?, phone_s = ?, email_s = ?, password = ? ';
        $sql .= 'where id_s = ? ';

        DB::update($sql, [
            //  $teacher->username,
            $student->fullname_s,
            $student->phone_s,
            $student->email_s,
            $student->password,
            $student->id_s]);

    }

}
