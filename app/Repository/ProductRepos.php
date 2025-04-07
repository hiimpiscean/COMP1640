<?php

namespace App\Repository;

use Illuminate\Support\Facades\DB;

class ProductRepos
{

    public static function getAllProductWithCategory() {
        $sql = 'select p.*, c.name_cate as categoryName ';
        $sql .= 'from product as p ';
        $sql .= 'join category as c on p.categoryid = c.id_cate ';
        $sql .= 'order by p.name_p';

        return DB::select ($sql);

    }
    public static function getProductById($id_p){
        $sql = 'select p.* ';
        $sql .= 'from product as p ';
        $sql .= 'where p.id_p = ? ';
        return DB::select($sql, [$id_p]);

    }

    public static function getAllProduct()
    {
        return DB::table('product')->get(); 
    }

    public static function getProductByName($productName)
    {
        $product = DB::table('product')->where('name_p', $productName)->first();

        if (!$product) {
            return (object) ['id_p' => 0, 'name_p' => 'Unknown', 'image_p' => '', 'price_p' => 0];
        }

        return $product;
    }

    public static function insert($product){
        $sql = 'insert into product ';
        $sql .= '(name_p, image_p, price_p, description_p, categoryid) ';
        $sql .= 'values (?, ?, ?, ?, ?) ';

        $result =  DB::insert($sql,
            [
                $product->name_p,
                $product->image_p,
                $product->price_p ,
                $product->description_p ,
                $product->categoryid]);

        if($result){
            return DB::getPdo()->lastInsertId();

        } else {
            return -1;
        }
    }

    public static function update($product){
        $sql = 'update product ';
        $sql .= 'set name_p = ?, image_p = ?, price_p = ?, description_p = ?, categoryid = ? ';
        $sql .= 'where id_p = ? ';

        DB::update($sql,
            [
                $product->name_p,
                $product->image_p,
                $product->price_p,
                $product->description_p,
                $product->categoryid,
                $product->id_p]);

    }
    public static function delete($id_p){
        $sql = 'delete from product ';
        $sql .= 'where id_p = ? ';

        DB::delete($sql, [$id_p]);

    }

}
