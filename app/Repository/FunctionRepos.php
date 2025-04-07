<?php

namespace App\Repository;

use Illuminate\Support\Facades\DB;

class FunctionRepos
{
    public static function searchForProducts($query) {
        return DB::table('product')
            ->where('name_p', 'like', "%{$query}%")
            ->paginate(10);
    }

    public static function getProductsByCateId($id_c){
            $sql = 'select p.* ';
            $sql .= 'from product as p ';
            $sql .= 'join category as c on c.id_cate = p.categoryid ';
            $sql .= 'where c.id_cate = ?';

            return DB::select($sql, [$id_c]);
    }
}

