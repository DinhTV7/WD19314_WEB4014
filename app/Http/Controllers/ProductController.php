<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category');

        // Tìm kiếm theo mã sản phẩm
        if ($request->filled('ma_san_pham')) {
            $query->where('ma_san_pham', 'LIKE', '%' . $request->ma_san_pham . '%');
        }
        // Tương tự thực hiện tìm kiếm sản phẩm theo:
        // Tên sản phẩm, Danh mục, Khoảng giá, Ngày nhập, Trạng thái

        $products = $query->paginate(10);

        // $products = DB::table('products')->where('deleted_at', null)->paginate(10);

        return view('admin.products.index', compact('products'));
    }

    public function show($id)
    {
        // Lấy ra dữ liệu chi tiết theo id
        $product = Product::with('category')->findOrFail($id);
        // dd($product->category->ten_danh_muc);
        // Đổ dữ liệu thông tin chi tiết ra giao diện
        return view('admin.products.show', compact('product'));
    }

    public function create()
    {
        // Lấy dữ liệu danh mục
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        // // Khởi tạo 1 đối tượng Product mới
        // $product = new Product();

        // // Lấy dữ liệu từ form
        // $product->ma_san_pham       = $request->ma_san_pham;
        // $product->ten_san_pham      = $request->ten_san_pham;
        // $product->category_id       = $request->category_id;
        // $product->gia               = $request->gia;
        // $product->gia_khuyen_mai    = $request->gia_khuyen_mai;
        // $product->so_luong          = $request->so_luong;
        // $product->ngay_nhap         = $request->ngay_nhap;
        // $product->mo_ta             = $request->mo_ta;
        // $product->trang_thai        = $request->trang_thai;

        // // Xử lý hình ảnh
        // if ($request->hasFile('hinh_anh')) {
        //     $imagePath = $request->file('hinh_anh')->store('images/products', 'public');
        //     $product->hinh_anh = $imagePath;
        // }

        // // Lưu sản phẩm
        // $product->save();

        // Validate
        $dataValidate = $request->validate([
            'ma_san_pham' => 'required|string|max:20|unique:products,ma_san_pham',
            'ten_san_pham' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'hinh_anh' => 'nullable|image|mimes:jpg,png,jpeg,gif',
            'gia' => 'required|numeric|min:0|max:99999999',
            'gia_khuyen_mai' => 'nullable|numeric|min:0|lt:gia',
            'so_luong' => 'required|integer|min:1',
            'ngay_nhap' => 'required|date',
            'mo_ta' => 'nullable|string',
            'trang_thai' => 'required|boolean'
        ]);

        // Xử lý hình ảnh
        if ($request->hasFile('hinh_anh')) {
            $imagePath = $request->file('hinh_anh')->store('images/products', 'public');
            $dataValidate['hinh_anh'] = $imagePath;
        }

        Product::create($dataValidate);

        return redirect()->route('admin.products.index');
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        // Validate
        $dataValidate = $request->validate([
            'ma_san_pham' => 'required|string|max:20|unique:products,ma_san_pham,' . $id,
            'ten_san_pham' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'hinh_anh' => 'nullable|image|mimes:jpg,png,jpeg,gif',
            'gia' => 'required|numeric|min:0|max:99999999',
            'gia_khuyen_mai' => 'nullable|numeric|min:0|lt:gia',
            'so_luong' => 'required|integer|min:1',
            'ngay_nhap' => 'required|date',
            'mo_ta' => 'nullable|string',
            'trang_thai' => 'required|boolean'
        ]);

        // Xử lý hình ảnh
        if ($request->hasFile('hinh_anh')) {
            $imagePath = $request->file('hinh_anh')->store('images/products', 'public');
            $dataValidate['hinh_anh'] = $imagePath;

            if ($product->hinh_anh) {
                // use Illuminate\Support\Facades\Storage;
                Storage::disk('public')->delete($product->hinh_anh);
            }
        }

        $product->update($dataValidate);

        return redirect()->route('admin.products.index');
    }

    public function destroy($id) 
    {
        $product = Product::findOrFail($id);

        if ($product->hinh_anh) {
            // use Illuminate\Support\Facades\Storage;
            Storage::disk('public')->delete($product->hinh_anh);
        }

        $product->delete();

        return redirect()->route('admin.products.index')
                    ->with('success', 'Xóa sản phẩm thành công!');
    }

    // Lab 2+3: Thực hiện các chức năng 
    // Tìm kiếm, Phân trang, Thêm, Sửa, Xóa, Validate
    // Tất cả các bảng đã làm ở lab 1
}
