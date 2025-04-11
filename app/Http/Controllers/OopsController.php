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
        $related = DB::table('products')
                        ->where('phone_brand_id', $data->phone_brand_id) 
                        ->where('id', '!=', $id) // bỏ qua chính nó
                        ->limit(8)
                        ->get();
        return view("giaodiennguoidung.chitiet", compact("data", "related"));
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
}