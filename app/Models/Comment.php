<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'product_id', // <<< THÊM 'product_id' VÀO ĐÂY
        'body',
        // KHÔNG cần thêm 'id', 'created_at', 'updated_at' vào đây
    ];

    // Quan hệ với User (Người viết comment)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Quan hệ với Product (Sản phẩm được comment)
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}