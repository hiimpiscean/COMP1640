<?php

namespace App\Repository;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash; // Thêm thư viện Hash

class StaffRepos
{
    public static function getAllStaff()
    {
        $sql = "select s.* ";
        $sql .= "from staff as s ";
        $sql .= "order by s.username ";

        return DB::select($sql);
    }

    public static function getStaffById($id_s)
    {
        $sql = "select s.* ";
        $sql .= "from staff as s ";
        $sql .= "where s.id_s = ? ";

        return DB::select($sql, [$id_s]);
    }

    public static function insert($staff)
    {
        $sql = "insert into staff ";
        $sql .= "(username, fullname_s, phone_s, email, password) ";
        $sql .= "values(?, ?, ?, ?, ?) ";

        // Mã hóa mật khẩu trước khi chèn vào cơ sở dữ liệu
        $hashedPassword = Hash::make($staff->password);

        DB::insert($sql, [
            $staff->username,
            $staff->fullname_s,
            $staff->phone_s,
            $staff->email,
            $hashedPassword // Lưu mật khẩu đã mã hóa
        ]);
    }

    public static function update($staff)
    {
        $sql = "update staff ";
        $sql .= "set username = ?, fullname_s = ?, phone_s = ?, email = ?, password = ? ";
        $sql .= "where id_s = ? ";

        // Mã hóa mật khẩu trước khi cập nhật vào cơ sở dữ liệu
        $hashedPassword = Hash::make($staff->password);

        DB::update($sql, [
            $staff->username,
            $staff->fullname_s,
            $staff->phone_s,
            $staff->email,
            $hashedPassword, // Cập nhật mật khẩu đã mã hóa
            $staff->id_s
        ]);
    }

    public static function delete($id_s)
    {
        $sql = "delete from staff ";
        $sql .= "where id_s = ? ";

        return DB::delete($sql, [$id_s]);
    }
}
