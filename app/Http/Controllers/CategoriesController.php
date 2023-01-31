<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use App\Models\Product;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class CategoriesController extends Controller
{
    public function index()
    {
        $data = Categories::all();

        return view('admin.categories', ['data' => $data, 'title' => 'Data Categories', 'active' => 'categories']);
    }

    public function store(Request $request)
    {
        $validate = $request->validate([
            'name' => 'required|string|unique:categories',

        ]);

        try {
            Categories::create($validate);
            Alert::toast('Data Saved Successfully !', 'success');
            return back();
        } catch (Exception $e) {
            $m = $e->getMessage();
            Alert::toast($m, 'error');
            return back();
        }
    }

    public function update(Request $request)
    {

        $validate = $request->validate([
            'name' => 'required|string|unique:categories',
        ]);

        try {
            Alert::toast('Data Saved Successfully !', 'success');
            return back();
        } catch (Exception $e) {
            $m = $e->getMessage();
            Alert::toast($m, 'error');
            return back();
        }
    }

    public function destroy($id)
    {
        // $where = DB::table('categories')->join('products', 'categories.id', '=', 'products.categories_id')->select('categories.id')->where('products.categories_id', '=', $id)->get();
        $where = Product::where('categories_id', $id)->get();
        if ($where->isEmpty()) {
            try {
                Categories::destroy($id);
                Alert::toast('Data Successfull Deleted !', 'success');
                return back();
            } catch (Exception $e) {
                $m = $e->getMessage();
                Alert::toast($m, 'error');
                return back();
            }
        } else {
            try {
                Alert::toast('Data Used in Products !', 'error');
                return back();
            } catch (Exception $e) {
                $m = $e->getMessage();
                Alert::toast($m, 'error');
                return back();
            }
        }
    }
}
