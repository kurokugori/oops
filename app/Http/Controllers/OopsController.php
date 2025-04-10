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

    public function cartadd(Request $request) // thêm sản phẩm vô giỏ hàng
    {
        $request->validate([
            "id"=>["required","numeric"],
            "num"=>["required","numeric"]
        ]);
        $id = $request->id;
        $num = $request->num;
        $total = 0;
        $cart = [];
        if(session()->has('cart'))
        {
            $cart = session()->get("cart");
            if(isset($cart[$id]))
            $cart[$id] += $num;
            else
            $cart[$id] = $num ;
        }
        else
        {
            $cart[$id] = $num ;
        }
        session()->put("cart",$cart);
        return count($cart);
    }


    public function order() // đặt hàng
    {
    $cart=[];
    $data =[];
    $quantity = [];
    if(session()->has('cart'))
    {
        $cart = session("cart");
        $list_case = "";
        foreach($cart as $id=>$value)
        {
            $quantity[$id] = $value;
            $list_case .=$id.", ";
        }
        $list_case = substr($list_case, 0,strlen($list_case)-2);
        $data = DB::table("products")->whereRaw("id in (".$list_case.")")->get();
    }
    return view("giaodiennguoidung.order",compact("quantity","data"));
    } 
}