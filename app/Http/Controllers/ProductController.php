<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use App\Models\Product;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use RealRashid\SweetAlert\Facades\Alert;



class ProductController extends Controller
{
    public function index()
    {
        $data = Product::with('categories')->get();
        $cat = Categories::all();

        return view('admin.products', ['data' => $data, 'title' => 'Data Products', 'cat' => $cat, 'active' => 'products']);
    }

    public function store(Request $request)
    {
        $validate = $request->validate([
            'code' => 'required|unique:products',
            'name' => 'required|string',
            'categories_id' => 'required|integer',
            'price' => 'required|integer',
            'stock' => 'required|integer',
            'description' => 'required',
            'image' => 'required',
            'image.*' => 'mimes:jpg,jpeg,png|max:2000'
        ]);


        $validate['image'] = round(microtime(true) * 1000) . '-' . str_replace(' ', '-', $request->file('image')->getClientOriginalName());

        try {
            Product::create($validate);
            $request->file('image')->storeAs('public/productsImg', $validate['image']);
            Alert::toast('Data Saved Successfully !', 'success');
            return back();
        } catch (Exception $e) {
            $message = $e->getMessage();
            return back()->withErrors($message)->withInput();
        }
    }

    public function update(Request $request)
    {
        $validate = $request->validate([
            'name' => 'required|string',
            'code' => 'required',
            'categories_id' => 'required',
            'stock' => 'required|integer',
            'price' => 'required|integer',
            'description' => 'required',
            'image.*' => 'mimes:jpg,jpeg,png|max:2000'
        ]);

        if ($request->hasFile('image')) {

            $validate['image'] = round(microtime(true) * 1000) . '-' . str_replace(' ', '-', $request->file('image')->getClientOriginalName());
            $request->file('image')->storeAs('public/productsImg', $validate['image']);
            try {
                $images = Product::where('id', $request->id)->first();
                File::delete('storage/productsImg/' . $images->image);
                Product::where('code', $request->code)->update($validate);
                return back()->with('success', 'Data Berhasil Ditambah');
            } catch (Exception $e) {
                $message = $e->getMessage();
                return back()->withErrors($message)->withInput();
            }
        } else {
            try {
                Product::where('code', $request->code)->update($validate);
                return back()->with('success', 'Data Berhasil Ditambah');
            } catch (Exception $e) {
                $message = $e->getMessage();
                return back()->withErrors($message)->withInput();
            }
        }
    }

    public function destroy($code)
    {
        try {
            $images = DB::table('products')->where('code', $code)->first();
            File::delete('storage/productsImg/' . $images->image);
            Product::where('code', $code)->delete();
            Alert::toast('Data Deleted Successfully !', 'success');
            return back();
        } catch (Exception $e) {
            $message = $e->getMessage();
            return back()->withErrors($message)->withInput();
        }
    }

    public function addstock()
    {
        $data = Product::all();

        return view('admin.addstock', ['data' => $data, 'title' => 'Add Stock', 'active' => 'addstock']);
    }

    public function fill($code)
    {
        $fill = Product::where('code', $code)->first();
        $fill = array(
            'code' => $fill->code,
            'name' => $fill->name,
        );
        return json_encode($fill);
    }

    public function add(Request $request)
    {
        try {
            $stock = Product::where('code', $request->code)->first();
            $add = $request->stock + $stock->stock;
            Product::where('code', $request->code)->update(array('stock' => $add));
            Alert::toast('Stock Updated Successfully !', 'success');
            return back();
        } catch (Exception $e) {
            $message = $e->getMessage();
            Alert::toast($message, 'error');
            return back();
        }
    }
}
