<?php

namespace App\Http\Controllers;

use App\Repository\BlogRepos;
use App\Repository\CommentRepos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class BlogController extends Controller
{
    public function index()
    {
        $blogs = collect(BlogRepos::getAllBlog())->sortByDesc('created_at'); // Dùng collection để sắp xếp
        foreach ($blogs as $b) {
            $b->comment = CommentRepos::getCommentsByBlog($b->id_b);
        }
        return view('blog.index', ['blog' => $blogs]);
    }

    public function show($id)
    {
        $blog = BlogRepos::getBlogById($id);
        $blog[0]->comment = CommentRepos::getCommentsByBlog($blog[0]->id_b);
        return view('blog.show', ['blog' => $blog[0]]);
    }

    public function create()
    {
        // Vì tác giả sẽ được lấy từ session, không cần truyền giá trị này vào form
        return view('blog.create', [
            "blog" => (object) [
                'id_b' => '',
                'title_b' => '',
                'content_b' => '',
                'image_b' => ''
            ]
        ]);
    }

    public function store(Request $request)
    {
        // Validate dữ liệu từ form
        $this->formValidate($request)->validate();

        // Xử lý file upload nếu có
        if ($request->hasFile('image_b')) {
            $file = $request->file('image_b');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads'), $fileName);
        } else {
            $fileName = null;
        }

        $currentUser = Session::get('username');

        $blog = (object) [
            'title_b' => $request->input('title_b'),
            'content_b' => $request->input('content_b'),
            'image_b' => $fileName, // lưu tên file đã upload
            'author_b' => $currentUser
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

        $this->formValidate($request, true)->validate();

        // Xử lý file upload nếu có
        if ($request->hasFile('image_b')) {
            $file = $request->file('image_b');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads'), $fileName);
        } else {
            $fileName = $request->input('current_image');
        }

        // Cập nhật lại tác giả theo thông tin người dùng hiện hành
        $currentUser = Session::get('username');

        $blog = (object) [
            'id_b' => $request->input('id_b'),
            'title_b' => $request->input('title_b'),
            'content_b' => $request->input('content_b'),
            'image_b' => $fileName,
            'author_b' => $currentUser
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

        // Lấy tên tài khoản từ session (hoặc hệ thống xác thực)
        $currentUser = Session::get('username');

        $data = (object) [
            'blog_id' => $blogId,
            'content_cmt' => $request->input('content_cmt'),
            'author_cmt' => $currentUser
        ];

        $newCommentId = CommentRepos::insertComment($data);

        return redirect()->back()->with('msg', 'Comment added successfully!');
    }

    // Phương thức xóa bình luận
    public function destroyComment(Request $request, $id, $commentId)
    {
        // Nếu cần, bạn có thể kiểm tra xem bình luận có thuộc blog có id = $id hay không.
        $deleted = CommentRepos::deleteComment($commentId);
        if ($deleted) {
            return redirect()->back()->with('msg', 'Comment deleted successfully!');
        } else {
            return redirect()->back()->with('msg', 'Không tìm thấy bình luận cần xóa hoặc có lỗi xảy ra!');
        }
    }

    // Hàm validate dữ liệu cho blog
    private function formValidate($request, $isUpdate = false)
    {
        $rules = [
            'title_b' => ['required'],
            'content_b' => ['required'],
        ];

        // Nếu không phải update thì yêu cầu phải upload ảnh
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
