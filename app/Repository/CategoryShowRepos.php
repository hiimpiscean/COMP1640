<?php

namespace App\Repository;

use Illuminate\Support\Facades\DB;

class CategoryShowRepos
{
// category hiển thị CRUD

    public static function getAllCategory() {
        $sql = 'select c.* ';
        $sql .= 'from category as c ';
        $sql .= 'order by c.name_cate';

        return DB::select ($sql);
    }

    public static function getCategoryById($id_cate){
        $sql = 'select c.* ';
        $sql .= 'from category as c ';
        $sql .= 'where c.id_cate = ? ';

        return DB::select($sql, [$id_cate]);
    }

    public static function getCategoryWithProductsById($id_cate){
        $sql = 'select p.* ';
        $sql .= 'from product as p ';
        $sql .= 'join category as c on p.categoryid = c.id_cate ';
        $sql .= 'where c.id_cate = ? ';

        return DB::select($sql, [$id_cate]);
    }

    public static function insert($category){
        $sql = 'insert into category ';
        $sql .= '(name_cate, image_cate) ';
        $sql .= 'values (?, ?) ';

        $result =  DB::insert($sql, [$category->name_cate, $category->image_cate]);
        if($result){
            return DB::getPdo()->lastInsertId();
        } else {
            return -1;
        }
    }

    public static function update($category){
        $sql = 'update category ';
        $sql .= 'set name_cate = ?, image_cate = ? ';
        $sql .= 'where id_cate = ? ';

        DB::update($sql, [$category->name_cate, $category->image_cate, $category->id_cate]);

    }

    public static function delete($id_cate){
        $sql = 'delete from category ';
        $sql .= 'where id_cate = ? ';

        DB::delete($sql, [$id_cate]);
    }
}
