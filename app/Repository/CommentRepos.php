<?php

namespace App\Repository;

use Illuminate\Support\Facades\DB;

class CommentRepos
{
    // Lấy danh sách bình luận theo blog_id
    public static function getCommentsByBlog($blogId)
    {
        $sql = 'select cmt.* ';
        $sql .= 'from comment as cmt ';
        $sql .= 'where cmt.blog_id = ? ';
        $sql .= 'order by cmt.id_cmt desc';
        return DB::select($sql, [$blogId]);
    }

    // Thêm mới bình luận
    public static function insertComment($data)
    {
        $sql = 'insert into comment ';
        $sql .= '(blog_id, content_cmt, author_cmt, created_at, updated_at)';
        $sql .= ' values (?, ?, ?, now(), now())';
        $result = DB::insert($sql, [
            $data->blog_id,
            $data->content_cmt,
            $data->author_cmt,
        ]);

        return $result ? DB::getPdo()->lastInsertId() : -1;
    }
    // Xóa bình luận theo id_cmt
    public static function deleteComment($commentId)
    {
        $sql = 'delete from comment ';
        $sql .= 'where id_cmt = ?';
        return DB::delete($sql, [$commentId]);
    }
}
