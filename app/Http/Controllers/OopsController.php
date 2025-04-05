<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class OopsController extends Controller
{
    function trangchu()
    {
        $data = DB::select("select * from products order by unit_price asc limit 0,8");
        return view("index", compact("data"));
    }

    function phone_brands($id)
    {
        $data = DB::select("select * from products where phone_brand_id = ?",[$id]);
        return view("index", compact("data"));
    }

    function chitiet($id)
    {
        $data = DB::table('products')->where('id', $id)->first();
        
        return view("giaodiennguoidung.chitiet", compact("data"));
    }

    public function search(Request $request)
    {
        $query = $request->input('query');

        // Tìm kiếm sản phẩm theo tên, hãng
        $data = DB::select(
            "SELECT p.id as product_id, p.*, b.brand_name 
             FROM products p
             JOIN phone_brands b ON p.phone_brand_id = b.id
             WHERE p.product_name LIKE ? OR b.brand_name LIKE ?",
            ['%' . $query . '%', '%' . $query . '%']
        );
        return view('giaodiennguoidung.results', compact('data', 'query'));
    }
}
