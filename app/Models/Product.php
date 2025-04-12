<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Comment; // <<< Import Comment model

class Product extends Model
{
    use HasFactory;
    // ... $fillable, $table, $primaryKey ...

   
    public function comments() 
    {
        // Lấy các comment, sắp xếp mới nhất trước, và lấy kèm thông tin user
        return $this->hasMany(Comment::class)->with('user:id,first_name,last_name')->latest();
    }
    protected $primaryKey = 'id'; // Tên cột khóa chính vẫn là 'id'
    protected $keyType = 'string'; // <<< Báo cho Eloquent biết nó là chuỗi
    public $incrementing = false;  // <<< Báo rằng nó không tự tăng
}