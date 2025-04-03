<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Mặc định trong 1 file migration bắt buộc phải có đủ hàm UP và hàm DOWN
    // Hàm UP dùng để cập nhật CSDL
    // Hàm DOWN là những công việc ngược lại so với hàm up

    /**
     * Run the migrations.
     */
    public function up(): void
    {

        Schema::create('products', function (Blueprint $table) {
            $table->id();
            // Quy định độ dài và ko cho phép mã sản phẩm trùng nhau
            $table->string('ma_san_pham', 20)->unique();
            $table->string('ten_san_pham'); 
            $table->decimal('gia', 10, 2);
            // nullable cho phép chứa giá trị là null
            $table->decimal('gia_khuyen_mai', 10, 2)->nullable();
            $table->unsignedInteger('so_luong'); // Số nguyên dương
            $table->date('ngay_nhap');
            $table->text('mo_ta')->nullable();
            $table->boolean('trang_thai')->default(true); // Set giá trị mặc định
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
