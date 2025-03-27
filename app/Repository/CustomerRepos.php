<?php

namespace App\Repository;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CustomerRepos
{
    public static function getAllCustomer() {
        $sql = "select c.* ";
        $sql .= "from customer as c ";
        $sql .= "order by c.fullname_c ";
        return DB::select($sql);
    }

    public static function getCustomerById($id_c){
        $sql = "select c.* ";
        $sql .= "from customer as c ";
        $sql .= "where c.id_c = ? ";
        $result = DB::select($sql, [$id_c]);
        return $result ? $result[0] : null;
    }

    public static function insert($customer): bool
    {
        $sql = "insert into customer ";
        $sql .= "(fullname_c, dob, gender, phone_c, email, address_c, password) ";
        $sql .= "values (?, ?, ?, ?, ?, ?, ?)";
        return DB::insert($sql, [
            $customer->fullname_c,
            $customer->dob,
            $customer->gender,
            $customer->phone_c,
            $customer->email,
            $customer->address_c,
            $customer->password
        ]);
    }


    public static function update($customer){
        $sql = "update customer ";
        $sql .= "SET fullname_c = ?, dob = ?, gender = ?, phone_c = ?, email = ?, address_c = ? ";
        $params = [
            $customer->fullname_c,
            $customer->dob,
            $customer->gender,
            $customer->phone_c,
            $customer->email,
            $customer->address_c
        ];

        if (!empty($customer->password)) {
            $sql .= ", password = ?";
            $params[] = $customer->password;
        }

        $sql .= " WHERE id_c = ?";
        $params[] = $customer->id_c;

        return DB::update($sql, $params);
    }

    public static function delete($id_c){
        $sql = "delete from customer ";
        $sql .= "where id_c = ?";
        return DB::delete($sql, [$id_c]);
    }
}
