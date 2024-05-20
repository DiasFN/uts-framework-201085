<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Product;

class ProductController extends Controller
{
    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            "name"=> "required|max:255",
            "description"=> "required",
            "price"=> "required|numeric",
            "image"=> "required|max:255",
            "category_id"=> "required|",
            "expired_at"=> "required|date",
            "modified_by"=> "required|max:255"
        ]);

        if($validator->fails()){
            return response()->json($validator->messages())->setStatusCode(422);
        }

        $payload = $validator->validated();

        $product = Product::create([
            "name"=> $payload["name"],
            "description"=> $payload["description"],
            "price"=> $payload["price"],
            "image"=> $payload["image"],
            "category_id"=> $payload["category_id"],
            "expired_at"=> $payload["expired_at"],
            "modified_by"=> $payload["modified_by"]
        ]);

        return response()->json([
            'msg'=>'Data Produk berhasil disimpan'
        ], 201);
    }

    function show(){
        $products = Product::all();

        return response()->json([
            'msg' => 'Data Produk Keseluruhan',
            'data'=> $products
        ],200);
    }

    public function update(Request $request, $id){
        $validator = Validator::make($request->all(), [
            "name"=> "required|max:255",
            "description"=> "required",
            "price"=> "required|numeric",
            "image"=> "required|max:255",
            "category_id"=> "required|",
            "expired_at"=> "required|date",
            "modified_by"=> "required|max:255"
        ]);

        if ($validator->fails()){
            return response()->json($validator->messages())-> setStatusCode(422);
        }

        $validated = $validator->validated();
        $products = Product::find( $id );
        if ($products){
            Product::where('id', $id)->update($validated);

            return response()->json("Data dengan id: {$id} berhasil di update", 200);
        }
    }

    public function delete($id){
        $product = Product::where('id',$id)->get();
        if ($product){
            Product::where('id', $id)->delete();

            return response()->json(["Data product dengan id: '.$id.' telah dihapus"], 200);
        }

        return response()->json(["Data product dengan id: '.$id.' tidak ditemukan"], 404);
    }
}
