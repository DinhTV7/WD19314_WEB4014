<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'products';

    protected $fillable = [
        'ma_san_pham',
        'ten_san_pham',
        'category_id',
        'hinh_anh',
        'gia',
        'gia_khuyen_mai',
        'so_luong',
        'ngay_nhap',
        'mo_ta',
        'trang_thai',
    ];

    protected $dates = ['deleted_at']; // Đảm bảo Laravel hiểu đây là kiểu ngày tháng

    // Tạo mối liên hệ với danh mục
    public function category() {
        return $this->belongsTo(Category::class, 'category_id');
    }
}
