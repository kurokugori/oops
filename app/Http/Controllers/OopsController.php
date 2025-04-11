<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use App\Models\DonHang;
use Illuminate\Support\Facades\Auth;

class OopsController extends Controller
{
    function trangchu()
    {
        $data = DB::table('products')->orderBy('unit_price', 'asc')->paginate(8);
        return view('index', compact('data'));
    }

    function phone_brands($id)
    {
        $data = DB::table('products')->where('phone_brand_id', $id)->paginate(8);
        return view('index', compact('data'));
    }

    function chitiet($id)
    {
        $data = DB::table('products')->where('id', $id)->first();
        
        return view("giaodiennguoidung.chitiet", compact("data"));
    }

    public function search(Request $request)
    {
        $query = $request->input('query');

        $data = DB::table('products as p')
            ->join('phone_brands as b', 'p.phone_brand_id', '=', 'b.id')
            ->where('p.product_name', 'LIKE', '%' . $query . '%')
            ->orWhere('b.brand_name', 'LIKE', '%' . $query . '%')
            ->select('p.id as product_id', 'p.*', 'b.brand_name')
            ->paginate(8)
            ->appends(['query' => $query]); // giữ lại từ khóa khi chuyển trang

        return view('giaodiennguoidung.results', compact('data', 'query'));
    }

    public function cartadd(Request $request)
    {
        $id = $request->id;
        $num = $request->num;

        $cart = session()->get("cart", []);

        if (isset($cart[$id])) {
            $cart[$id] += $num;
        } else {
            $cart[$id] = $num;
        }

        session()->put("cart", $cart);

        return response()->json(['count' => count($cart)]);
    }

    public function order()
    {
        $cart = session('cart', []);
        $quantity = [];
        $data = collect(); // Tạo collection rỗng mặc định

        if (!empty($cart)) {
            $list_product = [];

            foreach ($cart as $id => $value) {
                $quantity[$id] = $value;
                $list_product[] = $id; // Không cần dấu nháy vì dùng whereIn
            }

            if (!empty($list_product)) {
                $data = DB::table("products")
                    ->whereIn("id", $list_product)
                    ->get();
            }
        }

        return view("giaodiennguoidung.order", compact("quantity", "data"));
    }

    public function cartdelete(Request $request)
    {
        $request->validate([
        "id"=>["required"]
        ]);
        $id = $request->id;
        $total = 0;
        $cart = [];
        if(session()->has('cart'))
        {
        $cart = session()->get("cart");
        unset($cart[$id]);
        }
        session()->put("cart",$cart);
        return redirect()->route('order');
    }

 
//hàm oderCreate mới
   /* public function ordercreate(Request $request)
    {
        $request->validate([
            "hinh_thuc_thanh_toan" => ["required", "numeric"]
        ]);

        $data = [];
        $quantity = [];

        if (session()->has('cart')) {
            $cart = session("cart");

            // Danh sách ID sản phẩm (key của mảng cart)
            $list_product = implode(',', array_map(function ($id) {
                return "'" . addslashes($id) . "'";
            }, array_keys($cart))); // thêm dấu nháy đơn quanh từng ID

            // Lấy thông tin sản phẩm từ database
            $products = DB::table("products")
                ->whereRaw("id IN ($list_product)")
                ->get();

            // Tạo dữ liệu đơn hàng
            $order = [
                "ngay_dat_hang" => DB::raw("now()"),
                "tinh_trang" => 1,
                "hinh_thuc_thanh_toan" => $request->hinh_thuc_thanh_toan,
                "user_id" => Auth::user()->id,
            ];

            DB::transaction(function () use ($order, $products, $cart) {
                $id_don_hang = DB::table("don_hang")->insertGetId($order);

                $detail = [];
                foreach ($products as $product) {
                    $detail[] = [
                        "ma_don_hang" => $id_don_hang,
                        "product_id" => $product->id,
                        "so_luong" => $cart[$product->id],
                        "don_gia" => $product->unit_price,
                    ];
                }

                DB::table("chi_tiet_don_hang")->insert($detail);
                session()->forget('cart');
            });

            // Chuẩn bị dữ liệu gửi view
            foreach ($products as $product) {
                $quantity[$product->id] = $cart[$product->id];
            }

            $data = $products;
        }
<<<<<<< Updated upstream
        return view("giaodiennguoidung.order", compact('data','quantity'));
    }
=======

        return view("giaodiennguoidung.order", compact('data', 'quantity'));
    }*/

// hàm sửa từ oderCreate để thêm phần nhập thông tin
    public function saveOrder(Request $request)
    {
        $request->validate([
            'ten_nguoi_nhan' => 'required|string|max:255',
            'so_dien_thoai' => 'required|string|max:20',
            'dia_chi' => 'required|string|max:255',
            'hinh_thuc_thanh_toan' => 'required|in:1,2',
        ]);

        $selected_products = session('selected_products');
        $quantities = session('quantities');

        if (!$selected_products || !$quantities || count($selected_products) === 0) {
            return redirect()->route('order')->with('error', 'Không có sản phẩm nào để đặt hàng.');
        }

        // Lấy thông tin sản phẩm
        $products = DB::table('products')
            ->whereIn('id', $selected_products)
            ->get();

        DB::beginTransaction();

        try {
            // Tạo đơn hàng
            $orderId = DB::table('don_hang')->insertGetId([
                'ngay_dat_hang' => now(),
                'tinh_trang' => 1,
                'hinh_thuc_thanh_toan' => $request->hinh_thuc_thanh_toan,
                'ten_nguoi_nhan' => $request->ten_nguoi_nhan,
                'so_dien_thoai' => $request->so_dien_thoai,
                'dia_chi' => $request->dia_chi,
                'ghi_chu' => $request->ghi_chu,
                'user_id' => Auth::id(),
            ]);

            // Chi tiết đơn hàng
            $orderDetails = [];
            foreach ($products as $product) {
                $orderDetails[] = [
                    'ma_don_hang' => $orderId,
                    'product_id' => $product->id,
                    'so_luong' => $quantities[$product->id],
                    'don_gia' => $product->unit_price,
                ];
            }

            DB::table('chi_tiet_don_hang')->insert($orderDetails);

            DB::commit();

            // Xoá session
            session()->forget(['selected_products', 'quantities', 'cart']);

            return redirect()->route('order')->with('status', 'Đặt hàng thành công!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Đã xảy ra lỗi khi đặt hàng. Vui lòng thử lại.');
        }
    }


//hàm show bảng nhập thông tin
    public function showCheckoutForm(Request $request)
    {
        // Lưu vào session để bước sau dùng
            session([
                'selected_products' => json_decode($request->selected_products_json, true),
                'quantities' => json_decode($request->quantities_json, true),
                'hinh_thuc_thanh_toan' => $request->hinh_thuc_thanh_toan
            ]);

        return view('giaodiennguoidung.checkout'); // form nhập thông tin
    }

>>>>>>> Stashed changes
}