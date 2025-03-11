<?php

namespace App\Repository;

use Illuminate\Support\Facades\DB;

class AdminRepos
{
    public static function getAllAdmin() {
        // Sử dụng dấu nháy đơn cho literal string 'admin'
        $sql = "select a.*, 'admin' as role ";
        $sql .= "from admin as a ";
        $sql .= "order by a.username";

        return DB::select($sql);
    }

    public static function getAdminById($id_a){
        $sql = "select a.*, 'admin' as role ";
        $sql .= "from admin as a ";
        $sql .= "where a.id_a = ? ";

        return DB::select($sql, [$id_a]);
    }

    public static function update($admin){
        $sql = "update admin ";
        $sql .= "set username = ?, fullname_a = ?, phone_a = ?, email_a = ?, password = ? ";
        $sql .= "where id_a = ? ";

        DB::update($sql, [
            $admin->username,
            $admin->fullname_a,
            $admin->phone_a,
            $admin->email_a,
            $admin->password,
            $admin->id_a
        ]);
    }
}
