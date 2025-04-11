<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        // 1. Validate dữ liệu gửi lên từ form
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id',
            'body' => 'required|string|min:5|max:1000',
        ],
        [
            'product_id.required' => 'Thiếu thông tin sản phẩm để bình luận.',
            'product_id.exists' => 'Sản phẩm được bình luận không hợp lệ.',
            'body.required' => 'Vui lòng nhập nội dung bình luận.',
            'body.min' => 'Nội dung bình luận phải có ít nhất 5 ký tự.',
            'body.max' => 'Nội dung bình luận quá dài (tối đa 1000 ký tự).',
        ]);

        // Nếu validation thất bại, quay lại trang trước với lỗi và input cũ
        if ($validator->fails()) {
            return back()
                    ->withErrors($validator, 'comment_store')
                    ->withInput();
        }

        // 2. Tạo và lưu bình luận mới (Không còn try...catch)
        // Nếu có lỗi ở đây (ví dụ DB), Laravel sẽ tự ném exception và dừng lại
        Comment::create([
            'product_id' => $request->input('product_id'),
            'user_id' => Auth::id(),
            'body' => $request->input('body'),
        ]);

        // 3. Redirect về trang trước với thông báo thành công
        // Code sẽ chỉ chạy đến đây nếu Comment::create() thành công
        return back()->with('comment_success', 'Bình luận của bạn đã được gửi thành công!');

    }
}