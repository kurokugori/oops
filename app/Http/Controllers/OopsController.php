<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Product;

class OopsController extends Controller
{
    function trangchu()
    {
        /*
        $data = DB::select("select * from products order by unit_price asc limit 0,8");
        return view("index", compact("data"));
        */
        $title = 'Trang Chủ';
        // Sử dụng simplePaginate()
        $data = Product::orderBy('created_at', 'desc')
                       ->simplePaginate(8); // <<-- THAY ĐỔI Ở ĐÂY
   
        return view('index', [
            'title' => $title,
            'data' => $data
        ]);
    }


    function phone_brands($id)
    {
        $title = 'Sản phẩm theo hãng';


        $data = Product::where('phone_brand_id', $id) // Lọc theo ID hãng được truyền vào
                       ->orderBy('created_at', 'desc')
                       ->paginate(8); // Phân trang


        // Truyền đối tượng Paginator ($data) và $title vào view
        return view('index', [ //
            'title' => $title,
            'data' => $data //
        ]);
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