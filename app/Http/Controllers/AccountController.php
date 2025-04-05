<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash; // Cần nếu muốn cập nhật mật khẩu (nhưng không nên làm ở form này)
use Illuminate\Validation\Rule; // Để dùng Rule::unique()->ignore()

class AccountController extends Controller
{
    /**
     * Hiển thị form chỉnh sửa thông tin tài khoản.
     *
     * @param  Request $request
     * @return \Illuminate\View\View
     */
    public function edit(Request $request)
    {
        // Lấy thông tin user đang đăng nhập
        $user = $request->user(); // Hoặc Auth::user();

        // Trả về view dashboard, truyền dữ liệu user vào
        // Đảm bảo tên view đúng với vị trí file của bạn
        return view('giaodiennguoidung.dashboard', ['user' => $user]);
    }

    /**
     * Cập nhật thông tin tài khoản.
     *
     * @param  Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        // Lấy user đang đăng nhập
        $user = $request->user(); // Hoặc Auth::user();

        // Validate dữ liệu gửi lên
        $validatedData = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            // Email thường không cho phép đổi ở đây, nếu muốn đổi cần quy trình xác thực riêng
            // 'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone' => [
                'nullable', // Cho phép để trống
                'string',
                'max:20', // Giới hạn độ dài
                // Kiểm tra unique, nhưng bỏ qua chính user hiện tại
                Rule::unique('users', 'phone')->ignore($user->id),
            ],
            'address' => 'nullable|string|max:500', // Tăng max length nếu cần
        ], [
            // Custom validation messages (Vietnamese)
            'first_name.required' => 'Vui lòng nhập Tên.',
            'last_name.required' => 'Vui lòng nhập Họ.',
            'phone.unique' => 'Số điện thoại này đã được sử dụng.',
            'phone.max' => 'Số điện thoại không hợp lệ.',
            'address.max' => 'Địa chỉ quá dài.',
        ]);

        // --- Chỉ cập nhật các trường có trong $validatedData ---
        // Cách 1: Dùng update() (Yêu cầu các trường phải có trong $fillable của Model User)
        try {
             $user->update($validatedData);

             // Chuyển hướng về lại trang tài khoản với thông báo thành công
             return redirect()->route('account.edit')
                              ->with('success', 'Thông tin tài khoản đã được cập nhật thành công!');

        } catch(\Exception $e) {
             Log::error('Account Update Error: '. $e->getMessage());
              return redirect()->route('account.edit')
                              ->with('error', 'Đã có lỗi xảy ra khi cập nhật tài khoản.');
        }
    }
}