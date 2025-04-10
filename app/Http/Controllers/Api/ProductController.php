<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Product::with('category');

        if ($request->filled('ma_san_pham')) {
            $query->where('ma_san_pham', 'LIKE', '%' . $request->ma_san_pham . '%');
        }

        $products = $query->paginate(10);

        // return response()->json($products, 200);

        return ProductResource::collection($products);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
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

        $product = Product::create($dataValidate);

        return response()->json([
            'message' => 'Thêm sản phẩm thành công',
            'data' => new ProductResource($product),
            'status' => 201
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Lấy ra dữ liệu chi tiết theo id
        $product = Product::with('category')->findOrFail($id);

        // return response()->json($product, 200);

        return new ProductResource($product);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
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

        return response()->json([
            'message' => 'Cập nhật sản phẩm thành công',
            'data' => new ProductResource($product),
            'status' => 200
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);

        if ($product->hinh_anh) {
            // use Illuminate\Support\Facades\Storage;
            Storage::disk('public')->delete($product->hinh_anh);
        }

        $product->delete();

        return response()->json([
            'message' => 'Xóa sản phẩm thành công!'
        ]);
    }
}
