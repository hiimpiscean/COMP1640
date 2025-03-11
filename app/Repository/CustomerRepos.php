<?php

namespace App\Repository;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CustomerRepos
{
    public static function getAllCustomer() {
        $sql = 'select c.* ';
        $sql .= 'from customer as c ';
        $sql .= 'order by c.fullname_c ';
        return DB::select($sql);
    }

    public static function getCustomerById($id_c){
        $sql = 'select c.* ';
        $sql .= 'from customer as c ';
        $sql .= 'where c.id_c = ? ';
        $result = DB::select($sql, [$id_c]);
        return $result ? $result[0] : null;
    }

    public static function insert($customer){
        $plainPassword = isset($customer->password_c) ? $customer->password_c : null;

        $sql = 'insert into customer ';
        $sql .= '(fullname_c, dob, gender, phone_c, email_c, address_c, password_c) ';
        $sql .= 'values (?, ?, ?, ?, ?, ?, ?)';
        return DB::insert($sql, [
            $customer->fullname_c,
            $customer->dob,
            $customer->gender,
            $customer->phone_c,
            $customer->email_c,
            $customer->address_c,
            $plainPassword
        ]);
    }

    public static function update($customer){
        $sql = 'update customer ';
        $sql .= 'SET fullname_c = ?, dob = ?, gender = ?, phone_c = ?, email_c = ?, address_c = ? ';
        $params = [
            $customer->fullname_c,
            $customer->dob,
            $customer->gender,
            $customer->phone_c,
            $customer->email_c,
            $customer->address_c
        ];

        // Nếu mật khẩu mới được nhập, cập nhật nó
        if (!empty($customer->password_c)) {
            $sql .= ", password_c = ?";
            $params[] = Hash::make($customer->password_c);
        }

        // WHERE id_c = ?
        $sql .= " WHERE id_c = ?";
        $params[] = $customer->id_c;

        return DB::update($sql, $params);
    }

    public static function delete($id_c){
        $sql = 'delete from customer ';
        $sql .= 'where id_c = ?';
        return DB::delete($sql, [$id_c]);
    }
}
