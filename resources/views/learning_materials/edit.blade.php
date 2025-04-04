@extends('masters.uiMaster')

@section('main')
    <div class="container py-5">
        <h1 class="mb-4">Chỉnh sửa tài liệu học tập</h1>

        @if(!empty($material->id))
            @php
                $productId = request('product_id');
                $productName = '';

                if ($productId) {
                    $product = App\Repository\ProductRepos::getProductById($productId);
                    $productName = !empty($product) && is_array($product) && count($product) > 0 ? $product[0]->name_p : '';
                }
            @endphp
            <div class="alert alert-info">
                Đang chỉnh sửa tài liệu cho sản phẩm: <strong>{{ $productName }}</strong>
            </div>
        @endif

        <form action="{{ route('learning_materials.update', $material->id) }}" method="POST" enctype="multipart/form-data"
            class="bg-white shadow-sm p-4 rounded">
            @csrf

            <div class="form-group mb-3">
                <label for="title">Tiêu đề <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="title" name="title" value="{{ $material->title }}" required>
            </div>

            <div class="form-group mb-3">
                <label for="description">Mô tả</label>
                <textarea class="form-control" id="description" name="description"
                    rows="3">{{ $material->description }}</textarea>
            </div>

            <!-- Trường ẩn để lưu product_id từ request -->
            <input type="hidden" name="product_id" value="{{ $productId }}">

            <div class="form-group mb-3">
                <label for="file">Tệp tin mới (để trống nếu không thay đổi)</label>
                <input type="file" class="form-control" id="file" name="file">
                <small class="text-muted">Tệp hiện tại: {{ basename($material->file_path) }}</small>
            </div>

            <button type="submit" class="btn btn-primary">Cập nhật</button>
            <a href="{{ route('learning_materials.index', ['product_id' => $productId]) }}"
                class="btn btn-secondary">Hủy</a>
        </form>
    </div>
@endsection