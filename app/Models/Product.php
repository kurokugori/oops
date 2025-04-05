<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model // <--- Tên class phải là Product
{
    use HasFactory;

    // Thêm các thuộc tính fillable, casts, relationships nếu cần
    // protected $fillable = ['product_name', 'unit_price', 'image_url', 'phone_brand_id', ...];
    // protected $table = 'products'; // Tên bảng nếu khác quy ước
}