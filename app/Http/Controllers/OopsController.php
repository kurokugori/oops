<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;

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
        $cart = [];
        $data = [];
        $quantity = [];
        
        // Kiểm tra xem giỏ hàng có tồn tại trong session không
        if (session()->has('cart')) {
            $cart = session("cart");
            $list_product = [];
            
            // Lặp qua các sản phẩm trong giỏ hàng để tạo ra danh sách các ID sản phẩm
            foreach ($cart as $id => $value) {
                $quantity[$id] = $value;  // Lưu số lượng cho mỗi sản phẩm
                $list_product[] = "'$id'"; // Dùng dấu nháy đơn để bao quanh ID vì ID là chuỗi
            }
            
            // Chuyển mảng list_product thành chuỗi, cách nhau bởi dấu phẩy
            $list_product_str = implode(",", $list_product);

            // Truy vấn danh sách sản phẩm từ database dựa trên các ID sản phẩm trong giỏ
            $data = DB::table("products")
                    ->whereRaw("id in ($list_product_str)") // Dùng whereRaw để xử lý chuỗi ID
                    ->get();
        }

        // Trả về view với dữ liệu giỏ hàng và sản phẩm
        return view("giaodiennguoidung.order", compact("quantity", "data"));
    } 
}