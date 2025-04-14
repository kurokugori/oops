<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\QueryException; // Import QueryException

class AuthController extends Controller
{
    /**
     * Hiển thị trang chứa cả form đăng nhập và đăng ký.
     */
    public function showLoginRegisterForm()
    {
        
        return view('giaodiennguoidung.login_register');
    }

    /**
     * Xử lý dữ liệu gửi từ form đăng ký.
     */
    public function register(Request $request)
    {
        // --- Bước 1: Validate Input ---
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'email.unique' => 'Địa chỉ email này đã được sử dụng.',
            'password.confirmed' => 'Xác nhận mật khẩu không khớp.',
        ]);

        // --- Sửa tên route khi redirect lỗi ---
        $loginRegisterRoute = 'giaodiennguoidung.login_register.show'; // Đặt tên route vào biến cho dễ quản lý
        
         

        if ($validator->fails()) {
           
            return redirect()->route($loginRegisterRoute)
                        ->withErrors($validator, 'register')
                        ->withInput($request->except('password'));
        }

        // --- Bước 2: Tạo User ---
        try {
            $userData = [
                'first_name' => $request->input('first_name'),
                'last_name' => $request->input('last_name'),
                'email' => $request->input('email'),
                'password' => $request->input('password'), // Dựa vào casts trong Model
            ];

            $user = User::create($userData);

            // --- Bước 3: Đăng nhập User mới ---
            Auth::login($user); // Đảm bảo dòng này còn để tự động đăng nhập

            // --- Bước 4: Redirect về trang trước đó hoặc trang chủ ---
            // Sử dụng intended() với fallback là URL trang chủ
            return redirect()->intended('/trangchu')
                       ->with('success', 'Đăng ký và đăng nhập thành công!'); // Có thể đổi thông báo

        } catch (ValidationException $e) {
             Log::warning('Registration Validation Exception: ' . $e->getMessage());
             
             return redirect()->route($loginRegisterRoute)
                        ->withErrors($e->validator, 'register')
                        ->withInput($request->except('password'));
        } catch (QueryException $e) { // Sửa thành QueryException cụ thể
            Log::error('Registration Database Error: ' . $e->getMessage() . ' SQL: ' . $e->getSql());
            $errorCode = $e->errorInfo[1] ?? null; // Thêm ?? null để tránh lỗi nếu errorInfo không có index 1
            if ($errorCode == 1062) {
                 
                 return redirect()->route($loginRegisterRoute)
                           ->with('error', 'Thông tin đăng ký (Email hoặc SĐT) đã tồn tại.')
                           ->withInput($request->except('password'));
            }
             
             return redirect()->route($loginRegisterRoute)
                        ->with('error', 'Lỗi cơ sở dữ liệu trong quá trình đăng ký. Vui lòng thử lại.')
                        ->withInput($request->except('password'));

        } catch (\Exception $e) {
            Log::error('General Registration Error: ' . $e->getMessage() . ' - Line: ' . $e->getLine() . ' - File: ' . $e->getFile());
             
            return redirect()->route($loginRegisterRoute)
                       ->with('error', 'Đã có lỗi xảy ra trong quá trình đăng ký. Vui lòng thử lại.')
                       ->withInput($request->except('password'));
        }
    }

    /**
     * Xử lý dữ liệu gửi từ form đăng nhập.
     */
    public function login(Request $request)
    {
        // --- Bước 1: Validate Input ---
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string',
        ],[
            'email.required' => 'Vui lòng nhập địa chỉ email.',
            'email.email' => 'Địa chỉ email không hợp lệ.',
            'password.required' => 'Vui lòng nhập mật khẩu.',
        ]);
        
         $loginRegisterRoute = 'login_register.show'; // Thường chỉ là tên này

        // Nếu validation cơ bản thất bại
        if ($validator->fails()) {
            return redirect()->route($loginRegisterRoute)
                        ->withErrors($validator, 'login') 
                        ->withInput($request->except('password')); 
        }

        // --- Bước 2: Kiểm tra sự tồn tại của User ---
        $user = User::where('email', $request->email)->first();

        // --- Bước 3: Xử lý nếu User không tồn tại ---
        if (!$user) {
            // Quay lại trang login với thông báo lỗi "Tài khoản không tồn tại"
            
             throw ValidationException::withMessages([
                'login_error' => __('Tài khoản không tồn tại') // Thông báo lỗi
            ])->errorBag('login'); // Chỉ định error bag 'login'
            
        }

        // --- Bước 4: User tồn tại, thử xác thực mật khẩu ---
        $credentials = $request->only('email', 'password');
        $remember = $request->boolean('remember'); 

        if (Auth::attempt($credentials, $remember)) {
            // --- Bước 5: Đăng nhập thành công ---
            $request->session()->regenerate();

            // Chuyển hướng đến trang đích (trang trước đó hoặc trang chủ)  
            return redirect()->intended(route('trangchu'));
        }

        // --- Bước 6: Xác thực thất bại (Mật khẩu không chính xác) ---
         throw ValidationException::withMessages([
            'login_error' => __('Tên đăng nhập hoặc mật khẩu không chính xác') // Thông báo lỗi
        ])->errorBag('login'); // Chỉ định error bag 'login'
        
    
    }

    /**
     * Xử lý đăng xuất người dùng.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // --- Redirect về trang chủ sau khi đăng xuất ---
        return redirect('/trangchu'); // <-- Chuyển về trang chủ thay vì trang login
        
    }


    
}