@extends('layouts.admin')

@section('title', 'Chi tiết sản phẩm')

@section('content')
    <h1 class="mb-4">Chi tiết sản phẩm</h1>

    <div class="card">
        <div class="card-body">
            <div class="row">
                <!-- Cột hình ảnh -->
                <div class="col-md-4">
                    @if($product->hinh_anh)
                        <img src="{{ asset('storage/' . $product->hinh_anh) }}" class="img-fluid rounded" alt="{{ $product->ten_san_pham }}">
                    @else
                        <p>Không có ảnh</p>
                    @endif
                </div>

                <!-- Cột thông tin sản phẩm -->
                <div class="col-md-8">
                    <table class="table table-bordered">
                        <tr>
                            <th>Mã sản phẩm:</th>
                            <td>{{ $product->ma_san_pham }}</td>
                        </tr>
                        <tr>
                            <th>Tên sản phẩm:</th>
                            <td>{{ $product->ten_san_pham }}</td>
                        </tr>
                        <tr>
                            <th>Danh mục:</th>
                            <td>{{ $product->category->ten_danh_muc ?? 'Chưa có danh mục' }}</td>
                        </tr>
                        <tr>
                            <th>Giá:</th>
                            <td>{{ number_format($product->gia, 0, ',', '.') }} VND</td>
                        </tr>
                        <tr>
                            <th>Giá khuyến mãi:</th>
                            <td>
                                @if($product->gia_khuyen_mai)
                                    {{ number_format($product->gia_khuyen_mai, 0, ',', '.') }} VND
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Số lượng:</th>
                            <td>{{ $product->so_luong }}</td>
                        </tr>
                        <tr>
                            <th>Ngày nhập:</th>
                            <td>{{ date('d/m/Y', strtotime($product->ngay_nhap)) }}</td>
                        </tr>
                        <tr>
                            <th>Mô tả:</th>
                            <td>{{ $product->mo_ta }}</td>
                        </tr>
                        <tr>
                            <th>Trạng thái:</th>
                            <td>
                                @if($product->trang_thai)
                                    <span class="badge bg-success">Đang bán</span>
                                @else
                                    <span class="badge bg-danger">Ngừng bán</span>
                                @endif
                            </td>
                        </tr>
                    </table>

                    <!-- Nút quay lại -->
                    <a href="{{ route('admin.products.index') }}" class="btn btn-primary mt-3">
                        <i class="fas fa-arrow-left"></i> Quay lại danh sách
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
