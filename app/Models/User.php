<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Comment;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'first_name',   // 
        'last_name',    // 
        'email',
        'password',
        'phone',        // thu thập và lưu phone khi đăng ký
        'address',      // thu thập và lưu address khi đăng ký
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }


    // ... use statements, $fillable, $hidden, $casts ...

    // Đổi tên relationship và trỏ đến Comment model
    public function comments() // <<< ĐỔI TÊN RELATIONSHIP
    {
        return $this->hasMany(Comment::class); // <<< Trỏ đến Comment::class
    }

}
