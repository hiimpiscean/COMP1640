<?php

namespace App\Repository;

use Illuminate\Support\Facades\DB;

class BlogRepos
{
    public static function getAllBlogs()
    {
        $sql = 'select b.* ';
        $sql .= 'from blog as b ';
        $sql .= 'order by b.id_b ';
        return DB::select($sql);
    }

    public static function getBlogById($id)
    {
        $sql = 'select b.* ';
        $sql .= 'from blog as b ';
        $sql .= 'where b.id_b = ? ';
        return DB::select($sql, [$id]);
    }

    public static function insert($blog)
    {
        $sql = 'insert into blog ';
        $sql .= '(title_b, content_b, image_b, author_b) ';
        $sql .= 'values (?, ?, ?, ?)';

        $result = DB::insert($sql, [
            $blog->title_b,
            $blog->content_b,
            $blog->image_b,
            $blog->author_b
        ]);

        return $result ? DB::getPdo()->lastInsertId() : -1;
    }

    public static function update($blog)
    {
        $sql = 'update blog ';
        $sql .= 'set title_b = ?, content_b = ?, image_b = ?, author_b = ? ';
        $sql .= 'where id_b = ?';

        DB::update($sql, [
            $blog->title_b,
            $blog->content_b,
            $blog->image_b,
            $blog->author_b,
            $blog->id_b
        ]);
    }

    public static function delete($id)
    {
        $sql = 'delete from blog ';
        $sql .= 'where id_b = ?';
        DB::delete($sql, [$id]);
    }
}
