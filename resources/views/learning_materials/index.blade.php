@extends('masters.uiMaster')

@section('main')
  @php
    $currentProduct = null;
    $productName = '';
    $productId = request('product_id');

    if ($productId) {
    $productData = App\Repository\ProductRepos::getProductById($productId);
    if (!empty($productData) && is_array($productData) && count($productData) > 0) {
    $currentProduct = $productData[0]; // Lấy phần tử đầu tiên của mảng
    $productName = $currentProduct->name_p ?? '';
    }
    }
@endphp

  <div class="container learning-materials-container">
    <!-- Nút tạo mới tài liệu - Chỉ hiển thị cho giáo viên -->
    @if(Session::get('role') === 'teacher')
    <div class="text-right mb-4">
    <a href="{{ route('learning_materials.create', ['product_id' => $productId]) }}"
      class="btn btn-success btn-lg create-btn">
      <i class="fas fa-plus"></i> Tạo mới tài liệu
    </a>
    </div>
  @endif

    <h1 class="mb-4 text-center">
    @if($currentProduct)
    Tài liệu học tập: {{ $productName }}
  @else
  Danh sách tài liệu học tập
@endif
    </h1>

    @if(session('success'))
    <div class="alert alert-success">
    {{ session('success') }}
    </div>
  @endif

    @if(session('error'))
    <div class="alert alert-danger">
    {{ session('error') }}
    </div>
  @endif

    @if(isset($materialsByProduct) && count($materialsByProduct) > 0)
    <table class="table table-striped materials-table">
    <thead>
      <tr>
      <th>Tiêu đề</th>
      <th>Mô tả</th>
      <th>Người tải lên</th>
      <th>Trạng thái</th>
      <th>Thao tác</th>
      </tr>
    </thead>
    <tbody>
      @foreach($materialsByProduct as $material)
      <tr>
      <td>{{ $material->title }}</td>
      <td>{{ $material->description }}</td>
      <td>
      @php
    // Lấy vai trò người tạo từ session
    $createdByRole = session('material_' . $material->id . '_created_by_role');
    $createdById = session('material_' . $material->id . '_created_by_id');
    $createdByType = session('material_' . $material->id . '_created_by_type');

    // Nếu là giáo viên, hiển thị tên giáo viên
    if ($material->teacher_data) {
      echo $material->teacher_data->fullname_t . ' (GV)';
    }
    // Nếu có dữ liệu từ session
    elseif ($createdByType === 'staff') {
      // Lấy thông tin staff từ StaffRepos
      $staffInfo = app(\App\Repository\StaffRepos::class)->getStaffById($createdById);
      if (!empty($staffInfo) && is_array($staffInfo) && count($staffInfo) > 0) {
      echo ($staffInfo[0]->fullname_s ?? 'Nhân viên') . ' (NV)';
      }
    } elseif ($createdByType === 'admin') {
      // Lấy thông tin admin từ AdminRepos
      $adminInfo = app(\App\Repository\AdminRepos::class)->getAdminById($createdById);
      if (!empty($adminInfo) && is_array($adminInfo) && count($adminInfo) > 0) {
      echo ($adminInfo[0]->fullname_a ?? $adminInfo[0]->username ?? 'Quản trị viên') . ' (QTV)';
      } else {
      echo 'Quản trị viên';
      }
    }
    // Mặc định hiển thị ID giáo viên nếu không có thông tin khác
    else {
      echo 'Giáo viên #' . $material->teacher_id;
    }
  @endphp
      </td>
      <td>
      @if($material->status === 'approved')
      <span class="badge badge-success">Đã duyệt</span>
    @elseif($material->status === 'pending')
      <span class="badge badge-warning">Chờ duyệt</span>
    @else
      <span class="badge badge-danger">Từ chối</span>
    @endif
      </td>
      <td>
      <div class="action-buttons">
      @if($material->status === 'approved')
      <a href="{{ route('learning_materials.download', $material->id) }}"
      class="btn btn-primary btn-sm action-btn">
      <i class="fas fa-download"></i> Tải xuống
      </a>
    @elseif($material->status === 'pending')
      <span class="status-badge pending">
      <i class="fas fa-clock"></i> Đang chờ duyệt
      </span>
    @endif

      @if(Session::get('role') === 'teacher')
      <a href="{{ route('learning_materials.edit', ['id' => $material->id, 'product_id' => $productId]) }}"
      class="btn btn-warning btn-sm action-btn">
      <i class="fas fa-edit"></i> Sửa
      </a>
    @endif
      </div>
      </td>
      </tr>
    @endforeach
    </tbody>
    </table>
  @else
  <div class="alert alert-info">
  @if($currentProduct)
    Chưa có tài liệu nào cho sản phẩm này.
  @else
    Chưa có tài liệu nào.
  @endif
  </div>
@endif
  </div>

  <style>
    .learning-materials-container {
    max-width: 1500px;
    margin: auto;
    background: white;
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    margin-top: 100px;
    margin-bottom: 50px;
    }

    .create-btn {
    background-color: #28a745;
    color: white;
    padding: 10px 20px;
    border-radius: 5px;
    font-weight: bold;
    display: inline-block;
    transition: background 0.3s;
    text-decoration: none;
    margin-bottom: 20px;
    }

    .create-btn:hover {
    background-color: #218838;
    text-decoration: none;
    color: white;
    }

    body {
    padding-bottom: 50px;
    }

    .materials-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 30px;
    }

    .table th,
    .table td {
    border: 1px solid #ddd;
    padding: 15px;
    text-align: center;
    /* Căn giữa nội dung trong các ô */
    vertical-align: middle;
    /* Căn giữa theo chiều dọc */
    }

    .table th {
    background-color: #a7d1fb;
    color: white;
    font-weight: bold;
    }

    .table tr:nth-child(even) {
    background-color: #f9f9f9;
    }

    .table tr:hover {
    background-color: #f1f1f1;
    }

    .btn {
    position: relative;
    border: none;
    padding: 8px 15px;
    border-radius: 5px;
    font-weight: bold;
    display: inline-block;
    transition: all 0.3s;
    text-decoration: none;
    font-size: 14px;
    }

    .btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .btn-primary {
    background-color: #007bff;
    color: white;
    }

    .btn-primary:hover {
    background-color: #0056b3;
    color: white;
    }

    .btn-warning {
    background-color: #ffc107;
    color: #212529;
    }

    .btn-warning:hover {
    background-color: #e0a800;
    color: #212529;
    }

    .badge {
    padding: 5px 10px;
    border-radius: 3px;
    font-weight: bold;
    }

    .badge-success {
    background-color: #28a745;
    color: white;
    }

    .badge-warning {
    background-color: #ffc107;
    color: black;
    }

    .badge-danger {
    background-color: #dc3545;
    color: white;
    }

    h1 {
    margin-bottom: 30px;
    color: #333;
    }

    .action-buttons {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    align-items: center;
    justify-content: center;
    }

    .action-btn {
    min-width: 110px;
    text-align: center;
    margin: 0;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    font-size: 0.9rem;
    }

    .action-btn i {
    margin-right: 5px;
    }

    .status-badge {
    display: inline-block;
    padding: 8px 12px;
    border-radius: 4px;
    font-weight: bold;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    min-width: 150px;
    text-align: center;
    }

    .status-badge.pending {
    background-color: #fff3cd;
    color: #856404;
    border: 1px solid #ffeeba;
    }

    .status-badge i {
    margin-right: 5px;
    animation: pulse 1.5s infinite;
    }

    @keyframes pulse {
    0% {
      opacity: 1;
    }

    50% {
      opacity: 0.6;
    }

    100% {
      opacity: 1;
    }
    }
  </style>
@endsection

@section('script')
  <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
  <script>
    AOS.init({
    duration: 1000,
    once: true,
    });
  </script>
@endsection