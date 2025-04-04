@extends('masters.dashboardMaster')

@section('main')
    <div class="pending-materials-section">
        <h1 class="mb-4 section-title">Tài liệu chờ duyệt</h1>

        @if(session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
            </div>
        @endif

        <div class="table-responsive">
            <table class="table table-striped table-hover pending-table">
                <thead>
                    <tr>
                        <th width="15%">Tiêu đề</th>
                        <th width="20%">Mô tả</th>
                        <th width="15%">Sản phẩm</th>
                        <th width="15%">Tệp tin</th>
                        <th width="15%">Người tải lên</th>
                        <th width="20%">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($materials as $material)
                                    <tr>
                                        <td>
                                            <div class="material-title">{{ $material->title }}</div>
                                        </td>
                                        <td>
                                            <div class="material-description">{{ $material->description }}</div>
                                        </td>
                                        <td>
                                            @php
                                                $materialProductId = session('material_' . $material->id . '_product_id');
                                                $productName = 'Chưa xác định';

                                                if ($materialProductId) {
                                                    $productData = App\Repository\ProductRepos::getProductById($materialProductId);
                                                    if (!empty($productData) && is_array($productData) && count($productData) > 0) {
                                                        $productName = $productData[0]->name_p ?? '';
                                                    }
                                                }
                                            @endphp
                                            <span class="product-name">{{ $productName }}</span>
                                        </td>
                                        <td>
                                            @php
                                                $fileExtension = pathinfo($material->file_path, PATHINFO_EXTENSION);
                                                $fileName = basename($material->file_path);

                                                $fileIcon = 'fa-file';

                                                if (in_array($fileExtension, ['pdf'])) {
                                                    $fileIcon = 'fa-file-pdf';
                                                } elseif (in_array($fileExtension, ['doc', 'docx'])) {
                                                    $fileIcon = 'fa-file-word';
                                                } elseif (in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif'])) {
                                                    $fileIcon = 'fa-file-image';
                                                }
                                            @endphp
                                            <div class="file-info">
                                                <i class="fas {{ $fileIcon }}"></i>
                                                <div class="file-details">
                                                    <span class="file-name" title="{{ $fileName }}">{{ $fileName }}</span>
                                                    <span class="file-ext">.{{ $fileExtension }}</span>
                                                </div>
                                            </div>
                                            <a href="{{ route('learning_materials.download', $material->id) }}" class="preview-btn"
                                                target="_blank">
                                                <i class="fas fa-eye"></i> Xem
                                            </a>
                                        </td>
                                        <td>
                                            @if($material->teacher_data)
                                                <span class="teacher-name">{{ $material->teacher_data->fullname_t }}</span>
                                            @else
                                                <span class="teacher-name">{{ 'Giáo viên #' . $material->teacher_id }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="action-buttons">
                                                <form action="{{ route('learning_materials.approve', $material->id) }}" method="POST"
                                                    class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-success approval-btn">
                                                        <i class="fas fa-check"></i> Duyệt
                                                    </button>
                                                </form>

                                                <form action="{{ route('learning_materials.reject', $material->id) }}" method="POST"
                                                    class="d-inline">
                                                    @csrf
                                                    <button type="submit"
                                                        onclick="return confirm('Bạn có chắc chắn muốn từ chối và xóa tài liệu này? Hành động này không thể hoàn tác.');"
                                                        class="btn btn-danger reject-btn">
                                                        <i class="fas fa-times"></i> Từ chối
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center empty-message">
                                <i class="fas fa-info-circle"></i> Không có tài liệu nào đang chờ duyệt
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <style>
        .pending-materials-section {
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
            margin-bottom: 30px;
        }

        .section-title {
            color: #333;
            font-size: 1.5rem;
            border-bottom: 2px solid #007bff;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        /* Styles for material title and description */
        .material-title {
            font-weight: 600;
            color: #212529;
            font-size: 14px;
        }

        .material-description {
            color: #6c757d;
            font-size: 13px;
            max-height: 60px;
            overflow: hidden;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
        }

        .pending-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .pending-table th {
            background-color: #343a40;
            color: white;
            padding: 12px 15px;
            font-weight: 500;
            text-align: left;
            border: none;
        }

        .pending-table td {
            padding: 12px 15px;
            vertical-align: middle;
            border-top: 1px solid #dee2e6;
        }

        .pending-table tr:nth-child(even) {
            background-color: #f8f9fa;
        }

        .pending-table tr:hover {
            background-color: #f1f1f1;
        }

        /* Dashboard-style product and teacher names */
        .product-name {
            background-color: #e3f2fd;
            padding: 5px 10px;
            border-radius: 15px;
            font-weight: 500;
            font-size: 13px;
            color: #0d6efd;
            border: 1px solid #b6d4fe;
            display: inline-block;
        }

        .teacher-name {
            background-color: #f0f0f0;
            padding: 5px 10px;
            border-radius: 15px;
            font-weight: 500;
            font-size: 13px;
            color: #555;
            border: 1px solid #ddd;
            display: inline-block;
        }

        /* Improved file info styles */
        .file-info {
            display: flex;
            align-items: center;
            margin-bottom: 8px;
            background-color: #f8f9fa;
            padding: 6px 10px;
            border-radius: 5px;
            border-left: 3px solid #6c757d;
        }

        .file-info i {
            color: #6c757d;
            font-size: 16px;
            margin-right: 8px;
        }

        .file-details {
            display: flex;
            flex-direction: column;
        }

        .file-name {
            font-size: 13px;
            color: #444;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 150px;
        }

        .file-ext {
            font-size: 11px;
            color: #6c757d;
            margin-top: 2px;
        }

        .preview-btn {
            font-size: 12px;
            padding: 4px 8px;
            border-radius: 4px;
            background-color: transparent;
            color: #007bff;
            border: 1px solid #007bff;
            display: inline-block;
            transition: all 0.2s;
        }

        .preview-btn:hover {
            background-color: #007bff;
            color: white;
        }

        .preview-btn i {
            margin-right: 4px;
        }

        /* Aligned action buttons */
        .action-buttons {
            display: flex;
            gap: 8px;
            justify-content: flex-start;
        }

        .approval-btn,
        .reject-btn {
            padding: 5px 10px;
            border-radius: 4px;
            font-weight: 500;
            font-size: 13px;
            transition: all 0.2s;
            border: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .approval-btn {
            background-color: #28a745;
            color: white;
        }

        .approval-btn:hover {
            background-color: #218838;
            transform: translateY(-2px);
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .reject-btn {
            background-color: #dc3545;
            color: white;
        }

        .reject-btn:hover {
            background-color: #c82333;
            transform: translateY(-2px);
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .approval-btn i,
        .reject-btn i {
            margin-right: 5px;
            font-size: 12px;
        }

        .empty-message {
            padding: 30px;
            color: #6c757d;
            font-style: italic;
            text-align: center;
        }

        .empty-message i {
            margin-right: 5px;
        }

        /* Make the alert messages match dashboard style */
        .alert {
            border-radius: 5px;
            padding: 12px 15px;
            margin-bottom: 20px;
            border: 1px solid transparent;
        }

        .alert-success {
            color: #155724;
            background-color: #d4edda;
            border-color: #c3e6cb;
        }

        .alert-danger {
            color: #721c24;
            background-color: #f8d7da;
            border-color: #f5c6cb;
        }
    </style>
@endsection