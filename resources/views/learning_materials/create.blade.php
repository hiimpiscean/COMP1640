@extends('masters.uiMaster')

@section('main')
    <style>
        /* Reset và font chữ */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background-color: #f8f9fa;
            color: #333;
        }

        /* Container chính */
        .container-learning-materials {
            max-width: 800px;
            margin: 0 auto;
            padding: 2rem;
            margin-top: 50px;
        }

        /* Tiêu đề */
        h1 {
            color: #2c3e50;
            font-size: 2.5rem;
            font-weight: 600;
            margin-bottom: 2rem;
            text-align: center;
        }

        /* Alert thông tin */
        .alert-info {
            background-color: #e3f2fd;
            border-color: #90caf9;
            color: #0d47a1;
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 2rem;
        }

        /* Form container */
        .bg-white {
            background-color: #fff;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border-radius: 12px;
            padding: 2rem;
        }

        /* Form group */
        .form-group {
            margin-bottom: 1.5rem;
        }

        /* Labels */
        label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: #2c3e50;
        }

        /* Input fields */
        .form-control {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 1rem;
            transition: border-color 0.3s ease;
        }

        .form-control:focus {
            border-color: #3498db;
            box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.1);
            outline: none;
        }

        /* Textarea */
        textarea.form-control {
            min-height: 120px;
            resize: vertical;
        }

        /* File input */
        input[type="file"] {
            padding: 0.5rem;
            border: 2px dashed #ddd;
            border-radius: 8px;
            background-color: #f8f9fa;
        }

        input[type="file"]:hover {
            border-color: #3498db;
        }

        /* Buttons container */
        .d-flex {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 2rem;
        }

        /* Buttons */
        .btn {
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-secondary {
            background-color: #95a5a6;
            color: white;
            border: none;
        }

        .btn-secondary:hover {
            background-color: #7f8c8d;
            transform: translateY(-2px);
        }

        .btn-primary {
            background-color: #3498db;
            color: white;
            border: none;
        }

        .btn-primary:hover {
            background-color: #2980b9;
            transform: translateY(-2px);
        }

        /* Icons */
        .fas {
            font-size: 1rem;
        }

        /* Required field indicator */
        .text-danger {
            color: #e74c3c;
        }

        /* Responsive design */
        @media (max-width: 768px) {
            .container {
                padding: 1rem;
            }

            h1 {
                font-size: 2rem;
            }

            .bg-white {
                padding: 1.5rem;
            }

            .btn {
                padding: 0.5rem 1rem;
            }
        }
    </style>

    <div class="container-learning-materials py-5">
        <h1 class="mb-4">Tải lên tài liệu học tập</h1>

        @if(!empty($selectedProductId))
            @php
                $product = App\Repository\ProductRepos::getProductById($selectedProductId);
                $productName = !empty($product) && is_array($product) && count($product) > 0 ? $product[0]->name_p : '';
            @endphp
            <div class="alert alert-info">
                Đang tạo tài liệu cho sản phẩm: <strong>{{ $productName }}</strong>
            </div>
        @endif

        <form action="{{ route('learning_materials.store') }}" method="POST" enctype="multipart/form-data"
            class="bg-white shadow-sm p-4 rounded">
            @csrf

            <div class="form-group mb-3">
                <label for="title">Tiêu đề <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="title" name="title" required>
            </div>

            <div class="form-group mb-3">
                <label for="description">Mô tả</label>
                <textarea class="form-control" id="description" name="description" rows="3"></textarea>
            </div>

            <!-- Trường ẩn để lưu product_id từ request -->
            <input type="hidden" name="product_id" value="{{ $selectedProductId }}">

            <div class="form-group mb-3">
                <label for="file">Tệp tin <span class="text-danger">*</span></label>
                <input type="file" class="form-control" id="file" name="file" required>
            </div>

            <div class="d-flex justify-content-between mt-4">
                <a href="{{ route('learning_materials.index', ['product_id' => $selectedProductId]) }}"
                    class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Quay lại
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-upload"></i> Tải lên
                </button>
            </div>
        </form>
    </div>
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