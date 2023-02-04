<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\TransactionDetail;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index()
    {
        $product = Product::with('categories')->get();
        return view('admin.cashier', ['active' => 'cashier', 'title' => 'Kasir', 'product' => $product]);
    }

    public function autocomplete(Request $request)
    {
        $search = $request->search;

        if ($search == '') {
            $products = Product::orderby('name', 'asc')->select('id', 'code', 'name', 'price')->limit(5)->get();
        } else {
            $products = Product::orderby('name', 'asc')->select('id', 'code', 'name', 'price')->where('code', 'like', '%' . $search . '%')->limit(5)->get();
        }

        $response = array();
        foreach ($products as $p) {
            $response[] = array("id" => $p->id, "value" => $p->name, "label" => $p->code, "price" => $p->price);
        }

        return response()->json($response);
    }


    public function show($code)
    {

        $fill = TransactionDetail::where('code_transaction', $code)->get();
        $subtotal = $fill->sum('total_price');
        $no = 0;
        foreach ($fill as $f) {
            $no++;
            $fill = array(
                'no' => $no,
                'code' => $f->code_transaction,
                'id' => $f->products->name,
                'product_id' => $f->products_id,
                'price' => $f->total_price,
                'qty' => $f->quantity,
                'sub' => $subtotal,
                // 'name' => $fill->products->name,
            );
        }


        return json_encode($fill);
    }

    public function add(Request $request)
    {
        TransactionDetail::create([
            'code_transaction' => $request->transaction_code,
            'products_id' => $request->products_id,
            'quantity' => $request->quantity,
            'total_price' => $request->price * $request->quantity
        ]);


        return response()->json(
            [
                'success' => true,
                'message' => 'Data inserted successfully'
            ]
        );
    }

    public function delete(Request $request)
    {

        TransactionDetail::where([
            [
                'code_transaction', '=', $request->code
            ],
            [
                'products_id', '=', $request->product_id
            ]
        ])->delete();

        return response()->json(
            [
                'success' => true,
                'message' => 'Data deleted successfully'
            ]
        );
    }
}
