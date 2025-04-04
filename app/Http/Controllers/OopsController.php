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
        $data = DB::select("select * from products where id = ?",[$id])[0];
        return view("giaodiennguoidung.chitiet", compact("data"));
    }
}
