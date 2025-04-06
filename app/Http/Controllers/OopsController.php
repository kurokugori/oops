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
}