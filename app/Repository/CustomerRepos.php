<?php

namespace App\Repository;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CustomerRepos
{
    public static function getAllCustomer()
    {
        $sql = "SELECT c.* FROM customer AS c ORDER BY c.fullname_c";
        return DB::select($sql);
    }

    public static function getCustomerById($id_c)
    {
        $sql = "SELECT c.* FROM customer AS c WHERE c.id_c = ?";
        $result = DB::select($sql, [$id_c]);
        return $result ? $result[0] : null;
    }

    /**
     * Tìm khách hàng theo email
     * 
     * @param string $email
     * @return object|null
     */
    public static function getCustomerByEmail($email)
    {
        $sql = "SELECT c.* FROM customer AS c WHERE c.email = ?";
        $result = DB::select($sql, [$email]);
        return $result ? $result[0] : null;
    }
    
    /**
     * Tìm khách hàng theo username (trong trường hợp này có thể dùng trường fullname_c hoặc id_c)
     * 
     * @param string $username
     * @return object|null
     */
    public static function getCustomerByUsername($username)
    {
        // Giả sử username có thể là fullname_c
        $sql = "SELECT c.* FROM customer AS c WHERE c.fullname_c = ?";
        $result = DB::select($sql, [$username]);
        return $result ? $result[0] : null;
    }

    public static function insert($customer): bool
    {
        $sql = "INSERT INTO customer (fullname_c, dob, gender, phone_c, email, address_c, password) ";
        $sql .= "VALUES (?, ?, ?, ?, ?, ?, ?)";

        return DB::insert($sql, [
            $customer->fullname_c,
            $customer->dob,
            $customer->gender,
            $customer->phone_c,
            $customer->email,
            $customer->address_c,
            $customer->password // Mật khẩu đã được hash từ controller
        ]);
    }

    public static function update($customer)
    {
        $sql = "UPDATE customer SET fullname_c = ?, dob = ?, gender = ?, phone_c = ?, email = ?, address_c = ?";
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
            $params[] = $customer->password; // Mật khẩu đã được hash từ controller
        }

        $sql .= " WHERE id_c = ?";
        $params[] = $customer->id_c;

        return DB::update($sql, $params);
    }

    public static function delete($id_c)
    {
        $sql = "DELETE FROM customer WHERE id_c = ?";
        return DB::delete($sql, [$id_c]);
    }
}
