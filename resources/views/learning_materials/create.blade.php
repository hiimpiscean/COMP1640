@extends('masters.uiMaster')

@section('main')
    <div class="container py-5">
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

            <button type="submit" class="btn btn-primary">Tải lên</button>
        </form>
    </div>
@endsection