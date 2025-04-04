<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LearningMaterial;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;
use App\Repository\TeacherRepos;
use Illuminate\Support\Facades\Log;

class LearningMaterialController extends Controller
{
    public function __construct()
    {
        // Áp dụng middleware kiểm tra role là teacher cho các phương thức tạo và lưu tài liệu
        $this->middleware(function ($request, $next) {
            $role = Session::get('role');
            // Thêm điều kiện cho route edit và update
            if (
                $request->is('learning-materials/upload*') || $request->is('learning-materials/store*') ||
                $request->is('learning-materials/edit*') || $request->is('learning-materials/update*')
            ) {

                // Log để debug
                Log::info('Kiểm tra quyền giáo viên', [
                    'role' => $role,
                    'route' => $request->path(),
                    'session' => Session::all()
                ]);

                if ($role !== 'teacher') {
                    return redirect()->back()->with('error', 'Chỉ giáo viên mới có quyền tạo hoặc sửa tài liệu học tập.');
                }
            }
            return $next($request);
        });
    }

    public function index(Request $request)
    {
        try {
            // Lấy tất cả tài liệu
            $materials = LearningMaterial::all();

            // Nếu không có product_id, chuyển hướng về trang curriculum
            if (!$request->has('product_id') || empty($request->product_id)) {
                return redirect()->route('learning_materials.curriculum');
            }

            // Lấy product_id hiện tại
            $productId = $request->product_id;

            // Lưu product_id vào session
            Session::put('current_product_id', $productId);

            // Tạo mảng để lưu materials được lọc
            $materialsByProduct = [];

            // Lọc tài liệu theo product_id trong session
            foreach ($materials as $material) {
                $materialProductId = Session::get('material_' . $material->id . '_product_id');
                if ($materialProductId == $productId) {
                    $materialsByProduct[] = $material;
                }
            }

            // Chuyển đổi thành collection
            $materialsByProduct = collect($materialsByProduct);

            // Kiểm tra sản phẩm có tồn tại không
            $productData = app(\App\Repository\ProductRepos::class)->getProductById($productId);
            if (empty($productData) || !is_array($productData) || count($productData) === 0) {
                return redirect()->route('learning_materials.curriculum')
                    ->with('error', 'Sản phẩm không tồn tại. Vui lòng chọn sản phẩm khác.');
            }

            return view('learning_materials.index', compact('materialsByProduct', 'request'));
        } catch (\Exception $e) {
            Log::error('Lỗi khi lấy danh sách tài liệu: ' . $e->getMessage());
            return view('learning_materials.index', ['materialsByProduct' => collect([])]);
        }
    }

    public function create(Request $request)
    {
        // Kiểm tra người dùng có phải là giáo viên không
        $role = Session::get('role');
        if ($role !== 'teacher') {
            return redirect()->back()->with('error', 'Chỉ giáo viên mới có quyền tạo tài liệu học tập.');
        }

        // Lấy product_id từ request (nếu có)
        $selectedProductId = $request->input('product_id');

        // Kiểm tra product_id có tồn tại không
        if (empty($selectedProductId)) {
            return redirect()->route('learning_materials.curriculum')
                ->with('error', 'Vui lòng chọn sản phẩm trước khi tạo tài liệu.');
        }

        // Kiểm tra sản phẩm có tồn tại không
        $productData = app(\App\Repository\ProductRepos::class)->getProductById($selectedProductId);
        if (empty($productData) || !is_array($productData) || count($productData) === 0) {
            return redirect()->route('learning_materials.curriculum')
                ->with('error', 'Sản phẩm không tồn tại. Vui lòng chọn sản phẩm khác.');
        }

        // Log thông tin cho debug
        Log::info('Mở form tạo tài liệu', [
            'product_id' => $selectedProductId,
            'session' => Session::all()
        ]);

        return view('learning_materials.create', compact('selectedProductId'));
    }

    public function store(Request $request)
    {
        try {
            // Kiểm tra người dùng có phải là giáo viên không
            $role = Session::get('role');
            if ($role !== 'teacher') {
                return redirect()->back()->with('error', 'Chỉ giáo viên mới có quyền tạo tài liệu học tập.');
            }

            $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'file' => 'required|file|mimes:pdf,doc,docx,jpeg,png|max:10240',
                'product_id' => 'required',
            ]);

            $email = Session::get('email');

            // Kiểm tra thông tin giáo viên
            $teacher = collect(TeacherRepos::getAllTeacher())->firstWhere('email', $email);
            if (!$teacher) {
                return redirect()->back()->with('error', 'Không tìm thấy thông tin giáo viên.');
            }

            // Log thông tin giáo viên
            Log::info('Giáo viên tạo tài liệu', [
                'teacher_id' => $teacher->id_t,
                'email' => $email
            ]);

            // Kiểm tra file
            if (!$request->hasFile('file') || !$request->file('file')->isValid()) {
                return redirect()->back()->with('error', 'File tải lên không hợp lệ. Vui lòng thử lại.');
            }

            $path = $request->file('file')->store('learning_materials');

            $material = new LearningMaterial();
            $material->title = $request->title;
            $material->description = $request->description;
            $material->file_path = $path;
            $material->teacher_id = $teacher->id_t;
            $material->status = 'pending';
            $material->save();

            // Lưu thông tin product_id vào session
            Session::put('material_' . $material->id . '_product_id', $request->product_id);

            // Log để debug
            Log::info('Đã lưu tài liệu với product_id vào session', [
                'material_id' => $material->id,
                'product_id' => $request->product_id
            ]);

            return redirect()->route('learning_materials.index', ['product_id' => $request->product_id])
                ->with('success', 'Tài liệu đã được tải lên thành công. Đang chờ duyệt.');
        } catch (\Exception $e) {
            Log::error('Lỗi trong phương thức store: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Có lỗi xảy ra. Vui lòng thử lại.');
        }
    }

    // Hiển thị tài liệu chờ duyệt (dành cho nhân viên)
    public function pending()
    {
        try {
            // Không sử dụng with('teacher')
            $materials = LearningMaterial::where('status', 'pending')->get();

            Log::info('Đã lấy danh sách tài liệu chờ duyệt', [
                'count' => $materials->count()
            ]);

            return view('learning_materials.pending', compact('materials'));
        } catch (\Exception $e) {
            Log::error('Lỗi khi lấy danh sách tài liệu chờ duyệt: ' . $e->getMessage());
            return view('learning_materials.pending', ['materials' => collect([])]);
        }
    }

    // Duyệt tài liệu (dành cho nhân viên)
    public function approve($id)
    {
        try {
            // Debug thông tin
            Log::info('Bắt đầu duyệt tài liệu', [
                'id' => $id,
                'session_data' => Session::all()
            ]);

            $material = LearningMaterial::findOrFail($id);

            Log::info('Đã tìm thấy tài liệu', [
                'material_id' => $id,
                'current_status' => $material->status
            ]);

            // Cập nhật chỉ trạng thái, không cập nhật approved_by
            $material->status = 'approved';
            $result = $material->save();

            Log::info('Kết quả cập nhật', [
                'success' => $result,
                'material' => $material->toArray()
            ]);

            return redirect()->back()->with('success', 'Tài liệu đã được duyệt thành công.');
        } catch (\Exception $e) {
            Log::error('Lỗi khi duyệt tài liệu: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'id' => $id
            ]);
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi duyệt tài liệu: ' . $e->getMessage());
        }
    }

    // Từ chối tài liệu (dành cho nhân viên)
    public function reject($id)
    {
        try {
            $material = LearningMaterial::findOrFail($id);

            // Xóa file từ storage trước khi xóa bản ghi
            if (Storage::exists($material->file_path)) {
                Storage::delete($material->file_path);
                Log::info('Đã xóa file: ' . $material->file_path);
            }

            // Xóa thông tin từ session
            Session::forget('material_' . $id . '_product_id');

            // Xóa hoàn toàn bản ghi
            $result = $material->delete();

            Log::info('Tài liệu đã bị từ chối và xóa', [
                'material_id' => $id,
                'success' => $result
            ]);

            return redirect()->back()->with('success', 'Tài liệu đã bị từ chối và xóa khỏi hệ thống.');
        } catch (\Exception $e) {
            Log::error('Lỗi khi từ chối và xóa tài liệu: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'id' => $id
            ]);
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi từ chối tài liệu: ' . $e->getMessage());
        }
    }

    // Tải xuống tài liệu (cho cả sinh viên và quản lý)
    public function download($id)
    {
        try {
            // Lấy thông tin tài liệu
            $material = LearningMaterial::findOrFail($id);

            // Lấy vai trò của người dùng hiện tại
            $role = Session::get('role');

            // Nếu tài liệu chưa được duyệt và người dùng không phải là admin/staff thì từ chối
            if ($material->status !== 'approved' && !in_array($role, ['admin', 'staff'])) {
                return redirect()->back()->with('error', 'Tài liệu này chưa được duyệt hoặc không tồn tại.');
            }

            // Log thông tin tải xuống
            Log::info('Tải xuống tài liệu', [
                'material_id' => $id,
                'user_role' => $role,
                'user_id' => Session::get('id_t') ?? Session::get('id_s') ?? Session::get('id_a'),
                'status' => $material->status
            ]);

            return Storage::download($material->file_path);
        } catch (\Exception $e) {
            Log::error('Lỗi khi tải xuống tài liệu: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi tải xuống tài liệu: ' . $e->getMessage());
        }
    }

    /**
     * Edit an existing learning material
     */
    public function edit($id)
    {
        try {
            // Kiểm tra người dùng có phải là giáo viên không
            $role = Session::get('role');

            // Debug thông tin
            Log::info('Mở trang sửa tài liệu', [
                'id' => $id,
                'role' => $role,
                'session_data' => Session::all()
            ]);

            if ($role !== 'teacher') {
                return redirect()->back()->with('error', 'Chỉ giáo viên mới có quyền chỉnh sửa tài liệu học tập.');
            }

            // Lấy thông tin tài liệu
            $material = LearningMaterial::findOrFail($id);

            Log::info('Đã tìm thấy tài liệu', [
                'material_id' => $id,
                'material_data' => $material->toArray()
            ]);

            // Lấy product_id từ request hoặc session
            $productId = request('product_id');
            if (empty($productId)) {
                $productId = Session::get('material_' . $id . '_product_id');

                // Log để debug
                Log::info('Lấy product_id từ session', [
                    'material_id' => $id,
                    'product_id' => $productId
                ]);
            }

            Log::info('Product ID tìm thấy', [
                'product_id' => $productId
            ]);

            return view('learning_materials.edit', compact('material', 'productId'));
        } catch (\Exception $e) {
            Log::error('Lỗi khi chỉnh sửa tài liệu: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi mở trang chỉnh sửa tài liệu: ' . $e->getMessage());
        }
    }

    /**
     * Update an existing learning material
     */
    public function update(Request $request, $id)
    {
        try {
            // Kiểm tra người dùng có phải là giáo viên không
            $role = Session::get('role');

            // Debug thông tin
            Log::info('Cập nhật tài liệu', [
                'id' => $id,
                'role' => $role,
                'request_data' => $request->all(),
                'session_data' => Session::all()
            ]);

            if ($role !== 'teacher') {
                return redirect()->back()->with('error', 'Chỉ giáo viên mới có quyền chỉnh sửa tài liệu học tập.');
            }

            $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'file' => 'nullable|file|mimes:pdf,doc,docx,jpeg,png|max:10240',
                'product_id' => 'required',
            ]);

            // Lấy thông tin tài liệu
            $material = LearningMaterial::findOrFail($id);

            Log::info('Đã tìm thấy tài liệu để cập nhật', [
                'material_id' => $id,
                'material_data' => $material->toArray()
            ]);

            // Cập nhật thông tin cơ bản
            $material->title = $request->title;
            $material->description = $request->description;
            // Không lưu product_id vào database

            // Cập nhật thông tin product_id trong session
            Session::put('material_' . $material->id . '_product_id', $request->product_id);

            // Nếu có file mới thì cập nhật
            if ($request->hasFile('file') && $request->file('file')->isValid()) {
                // Xóa file cũ
                if (Storage::exists($material->file_path)) {
                    Storage::delete($material->file_path);
                }

                // Lưu file mới
                $path = $request->file('file')->store('learning_materials');
                $material->file_path = $path;

                Log::info('Đã cập nhật file mới', [
                    'new_path' => $path
                ]);
            }

            // Luôn đặt trạng thái về chờ duyệt sau khi cập nhật
            $material->status = 'pending';

            $material->save();

            Log::info('Đã lưu tài liệu thành công', [
                'material_id' => $material->id,
                'new_status' => 'pending'
            ]);

            return redirect()->route('learning_materials.index', ['product_id' => $request->product_id])
                ->with('success', 'Tài liệu đã được cập nhật thành công và đang chờ duyệt.');
        } catch (\Exception $e) {
            Log::error('Lỗi khi cập nhật tài liệu: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi cập nhật tài liệu: ' . $e->getMessage());
        }
    }
}
