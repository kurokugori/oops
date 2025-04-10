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

    public function ordercreate(Request $request)
    {
        $request->validate([
        "hinh_thuc_thanh_toan"=>["required","numeric"]
        ]);
        $data = [];
        $quantity = [];
        if(session()->has('cart'))
        {
        $order = ["ngay_dat_hang"=>DB::raw("now()"),"tinh_trang"=>1,
        "hinh_thuc_thanh_toan"=>$request->hinh_thuc_thanh_toan,
        "user_id"=>Auth::user()->id];
        DB::transaction(function () use ($order) {
        $id_don_hang = DB::table("don_hang")->insertGetId($order);
        $cart = session("cart");
        $list_product = "";
        $quantity = [];
        foreach($cart as $id=>$value)
        {
        $quantity[$id] = $value;
        $list_product .=$id.", ";
        }
        $list_product = substr($list_product, 0,strlen($list_product)-2);
        $data = DB::table("products")
            ->whereRaw("id in ($list_product_str)") // Dùng whereRaw để xử lý chuỗi ID
            ->get();        
        $detail = [];
        foreach($data as $row)
        {
        $detail[] = ["ma_don_hang"=>$id_don_hang,"product_id"=>$row->id,
        "so_luong"=>$quantity[$row->id],"don_gia"=>$row->gia_ban];
        }
        DB::table("chi_tiet_don_hang")->insert($detail);
        session()->forget('cart');
        });
        }
        return view("giaodiennguoidung.order", compact('data','quantity'));
    }

    /*public function ordercreate(Request $request)
    {
        $request->validate([
            "hinh_thuc_thanh_toan"=>["required","numeric"]
        ]);
        $data = [];
        $quantity = [];
        if(session()->has('cart'))
        {
            $order = ["order_date"=>DB::raw("now()"),"order_status"=>1,
                    "hinh_thuc_thanh_toan"=>$request->hinh_thuc_thanh_toan,//thêm cột hinh_thuc_thanh_toan trong bảng order(smallint)
                    "user_id"=>Auth::user()->id];
            DB::transaction(function () use ($order) {
            $id_don_hang = DB::table("orders")->insertGetId($order);
            $cart = session("cart");
            $list_product = "";
            $quantity = [];
            foreach($cart as $id=>$value)
        {
            $quantity[$id] = $value;
            $list_product .=$id.", ";
        }
        $list_product = substr($list_product, 0,strlen($list_product)-2);
        $data = DB::table("products")
                    ->whereRaw("id in ($list_product_str)") // Dùng whereRaw để xử lý chuỗi ID
                    ->get();
        $detail = [];
        foreach($data as $row)
        {
            $detail[] = ["order_id"=>$id_don_hang,"product_id"=>$row->id,
            "quantity"=>$quantity[$row->id],"unit_price"=>$row->gia_ban];
        }
            DB::table("order_details")->insert($detail);
            session()->forget('cart');
        });
        }
        return view("giaodiennguoidung.order", compact('data','quantity'));
    }*/
}