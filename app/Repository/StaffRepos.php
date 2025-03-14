<?php

namespace App\Repository;

use Illuminate\Support\Facades\DB;

class StaffRepos
{
    public static function getAllStaff() {
        $sql = "select s.*, 'staff' as role ";
        $sql .= "from staff as s ";
        $sql .= "order by s.username";

        return DB::select($sql);
    }

    public static function getStaffById($id_s){
        $sql = "select s.*, 'staff' as role ";
        $sql .= "from staff as s ";
        $sql .= "where s.id_s = ? ";

        return DB::select($sql, [$id_s]);
    }

    public static function insert($staff){
        $sql = "insert into staff ";
        $sql .= "(username, fullname_s, phone_s, email, password) ";
        $sql .= "values(?, ?, ?, ?, ?)";

        DB::insert($sql, [
            $staff->username,
            $staff->fullname_s,
            $staff->phone_s,
            $staff->email,
            $staff->password
        ]);
    }

    public static function update($staff){
        $sql = "update staff ";
        $sql .= "set username = ?, fullname_s = ?, phone_s = ?, email = ?, password = ? ";
        $sql .= "where id_s = ? ";

        DB::update($sql, [
            $staff->username,
            $staff->fullname_s,
            $staff->phone_s,
            $staff->email,
            $staff->password,
            $staff->id_s
        ]);
    }

    public static function delete($id_s){
        $sql = "delete from staff ";
        $sql .= "where id_s = ?";

        return DB::delete($sql, [$id_s]);
    }
}
