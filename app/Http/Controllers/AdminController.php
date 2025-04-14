<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.index'); 
    }
    public function showLoginForm()
    {
        return view('auth.login');
    }
    public function login(Request $request)
        {
            // Xác thực dữ liệu đầu vào
            $request->validate([
                'username' => 'required|string',
                'password' => 'required|string',
            ]);

            // Truy vấn để xác minh người dùng
            $user = DB::table('admin')->where('username', $request->username)->first();
            $pass = DB::table('admin')->where('password', $request->password)->first();
            if (!$user) {
                return back()->withErrors([
                    'username' => 'Tên đăng nhập không tồn tại.',
                ]);
            }
            if (!$pass) {
                return back()->withErrors([
                    'password' => 'Mật khẩu không chính xác..',
                ]);
            }
            $request->session()->put('username', $user->username);
            return redirect()->route('admin.index');

        }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
    
/*--------------------------------*/

            public function manageProduct()
            {
                $data = DB::table('products')->get();
                return view('admin.products', compact('data'));    
            }


            public function oopscreate(){
                $phone_brands = DB::table("phone_brands")->get();
                $action = "add";
                return view("admin.oop_form",compact("phone_brands","action"));
            }
        
            public function oopssave($action, Request $request)
            {
                $request->validate([
                    'image_url' => ['nullable', 'image'],
                    'id' => ['required', 'string', 'max:200'],
                    'phone_brand_id' => ['required', 'string', 'max:200'],
                    'product_name' => ['required', 'string', 'max:200'],
                    'description' => ['required', 'string', 'max:255'], // Tăng giới hạn lên 255
                    'unit_price' => ['required', 'numeric', 'max:1000000'], // Tăng giới hạn giá
                ]);
        
                $data = $request->except("_token");
        
                if($action=="edit")
                    $data = $request->except("_token", "id");
        
                    if($request->hasFile("image_url"))
                    {
                        $fileName = $request->file('image_url')->getClientOriginalName(); // giữ nguyên tên file gốc
                        $request->file('image_url')->storeAs('public/anh', $fileName);
                        $data['image_url'] = $fileName;
                    }

                //$data = $request->except("id","_token");
                $message = "";
                if($action=="add")
                {
                    DB::table("products")->insert($data);
                    $message = "Thêm thành công";
                }
                else if($action=="edit")
                {
                    $id = $request->id;
                    DB::table("products")->where("id",$id)->update($data);
                    $message = "Cập nhật thành công";
                }
                return redirect()->route('admin.products')->with('status', $message);
            }
        
            public function oopsedit($id){
                $action = "edit";
                $phone_brands = DB::table("phone_brands")->get();
                $products = DB::table("products")->where("id",$id)->first();
                return view("admin.oop_form",compact("phone_brands","action","products"));
            }
        
            public function oopsdelete(Request $request)
            {
                $id = $request->id;
                DB::table("products")->where("id",$id)->delete();
                return redirect()->route('admin.products')->with('status', "Xóa thành công");
            }

//Quản lý đơn đặt hàng
            public function manageOrders()
        {
            $data = DB::table('don_hang')->get();
            return view('admin.manage-orders', compact('data'));  
        }

        public function updateOrderStatus(Request $request, $id)
        {
            DB::table('don_hang')->where('ma_don_hang', $id)->update([
                'trang_thai' => $request->input('trang_thai'),
            ]);

            return redirect()->back()->with('status', 'Cập nhật trạng thái thành công!');
        }

        public function ajaxOrderDetails($ma_don_hang)
{
    $details = DB::table('chi_tiet_don_hang')
                ->join('products', 'chi_tiet_don_hang.product_id', '=', 'products.id')
                ->where('chi_tiet_don_hang.ma_don_hang', $ma_don_hang)
                ->select('products.product_name', 'products.image_url', 'chi_tiet_don_hang.so_luong', 'products.unit_price')
                ->get();

    $tong = 0;
    ob_start();
    echo "<table class='table table-bordered'>";
    echo "<thead><tr><th>Sản phẩm</th><th>Số lượng</th><th>Đơn giá</th><th>Thành tiền</th></tr></thead><tbody>";
    foreach ($details as $item) {
        $thanhTien = $item->unit_price * $item->so_luong;
        $tong += $thanhTien;
        echo "<tr>";
        echo "<td><img src='" . asset('anh/' . $item->image_url) . "' width='50'> $item->product_name</td>";
        echo "<td>$item->so_luong</td>";
        echo "<td>" . number_format($item->unit_price, 0, ',', '.') . "đ</td>";
        echo "<td>" . number_format($thanhTien, 0, ',', '.') . "đ</td>";
        echo "</tr>";
    }
    echo "<tr><td colspan='3' class='text-right'><b>Tổng cộng</b></td><td><b>" . number_format($tong, 0, ',', '.') . "đ</b></td></tr>";
    echo "</tbody></table>";

    return ob_get_clean();
}

//Quản lý doanh thu
        public function manageRevenue()
        {
            return view('admin.manage-revenue'); 
        }

}