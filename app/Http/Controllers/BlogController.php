<?php

namespace App\Http\Controllers;

use App\Repository\BlogRepos;
use App\Repository\CommentRepos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BlogController extends Controller
{
    public function index()
    {
        $blog = BlogRepos::getAllBlogs();
        foreach ($blog as $b) {
            $b->comment = CommentRepos::getCommentsByBlog($b->id_b);
        }
        return view('blog.index', ['blog' => $blog]);
    }

    public function show($id)
    {
        $blog = BlogRepos::getBlogById($id);
        $blog[0]->comment = CommentRepos::getCommentsByBlog($blog[0]->id_b);
        return view('blog.show', ['blog' => $blog[0]]);
    }

    public function create()
    {
        return view('blog.create', [
            "blog" => (object)[
                'id_b' => '',
                'title_b' => '',
                'content_b' => '',
                'image_b' => '',
                'author_b' => ''
            ]
        ]);
    }

    public function store(Request $request)
    {
        $this->formValidate($request)->validate();

        // Xử lý file upload nếu có
        if ($request->hasFile('image_b')) {
            $file = $request->file('image_b');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads'), $fileName);
        } else {
            $fileName = null;
        }

        $blog = (object)[
            'title_b'   => $request->input('title_b'),
            'content_b' => $request->input('content_b'),
            'image_b'   => $fileName, // lưu tên file đã upload
            'author_b'  => $request->input('author_b')
        ];

        $newId = BlogRepos::insert($blog);

        return redirect()->action('BlogController@index')
            ->with('msg', 'New Blog with id: ' . $newId . ' has been inserted');
    }

    public function edit($id)
    {
        $blog = BlogRepos::getBlogById($id);
        return view('blog.edit', ["blog" => $blog[0]]);
    }

    public function update(Request $request, $id)
    {
        if ($id != $request->input('id_b')) {
            return redirect()->action('BlogController@index');
        }

        $this->formValidate($request)->validate();

        // Xử lý file upload nếu có
        if ($request->hasFile('image_b')) {
            $file = $request->file('image_b');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads'), $fileName);
        } else {
            $fileName = $request->input('current_image');
        }

        $blog = (object)[
            'id_b' => $request->input('id_b'),
            'title_b' => $request->input('title_b'),
            'content_b' => $request->input('content_b'),
            'image_b' => $fileName,
            'author_b' => $request->input('author_b')
        ];

        BlogRepos::update($blog);

        return redirect()->action('BlogController@index')
            ->with('msg', 'Update Successfully');
    }

    public function confirm($id)
    {
        $blog = BlogRepos::getBlogById($id);
        return view('blog.confirm', ['blog' => $blog[0]]);
    }

    public function destroy(Request $request, $id_b)
    {
        if ($request->input('id_b') != $id_b) {
            return redirect()->action('BlogController@index');
        }

        BlogRepos::delete($id_b);
        return redirect()->action('BlogController@index')
            ->with('msg', 'Delete Successfully');
    }

    // Phương thức thêm bình luận cho blog
    public function storeComment(Request $request, $blogId)
    {
        $request->validate([
            'content_cmt' => 'required',
        ]);
        $data = (object)[
            'blog_id' => $blogId,
            'content_cmt' => $request->input('content_cmt')
        ];
        $newCommentId = CommentRepos::insertComment($data);

        return redirect()->back()->with('msg', 'Comment added successfully!');
    }
    // Phương thức xóa bình luận
    public function destroyComment(Request $request, $commentId)
    {
        CommentRepos::deleteComment($commentId);
        return redirect()->back()->with('msg', 'Comment deleted successfully!');
    }

    private function formValidate($request, $isUpdate = false)
    {
        $rules = [
            'title_b' => ['required'],
            'content_b' => ['required'],
        ];

        if (!$isUpdate) {
            $rules['image_b'] = ['required'];
        }

        return Validator::make(
            $request->all(),
            $rules,
            [
                'title_b.required' => 'Please enter title',
                'content_b.required' => 'Please enter content!',
                'image_b.required' => 'Please upload an image',
            ]
        );
    }
}
