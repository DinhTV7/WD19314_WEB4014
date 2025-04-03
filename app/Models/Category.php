<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    // Để sử dụng đc factory tạo dữ liệu ta cần phải sử dụng thư viện
    use HasFactory;
    // Quy định model này thao tác với bảng nào
    protected $table = 'categories';
    // Các trường trong bảng đều phải đưa vào fillable
    protected $fillable = [
        'ten_danh_muc',
        'trang_thai'
    ];
    // Tạo mỗi liên hệ với product
    public function products() {
        return $this->hasMany(Product::class, 'category_id');
    }
}
