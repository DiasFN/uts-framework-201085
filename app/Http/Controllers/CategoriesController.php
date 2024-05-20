<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Categories;

class CategoriesController extends Controller
{
    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            "name"=> "required|max:255"
        ]);

        if($validator->fails()){
            return response()->json($validator->messages())->setStatusCode(422);
        }

        $payload = $validator->validated();

        $product = Categories::create([
            "name"=> $payload["name"]
        ]);

        return response()->json([
            'msg'=>'Data Kategori berhasil disimpan'
        ], 201);
    }

    function show(){
        $products = Categories::all();

        return response()->json([
            'msg' => 'Data Kategori Keseluruhan',
            'data'=> $products
        ],200);
    }

    public function update(Request $request, $id){
        $validator = Validator::make($request->all(), [
            "name"=> "required|max:255"
        ]);

        if ($validator->fails()){
            return response()->json($validator->messages())-> setStatusCode(422);
        }

        $validated = $validator->validated();
        $products = Categories::find( $id );
        if ($products){
            Categories::where('id', $id)->update($validated);

            return response()->json("Data dengan id: {$id} berhasil di update", 200);
        }
    }

    public function delete($id){
        $product = Categories::where('id',$id)->get();
        if ($product){
            Categories::where('id', $id)->delete();

            return response()->json(["Data product dengan id: '.$id.' telah dihapus"], 200);
        }

        return response()->json(["Data product dengan id: '.$id.' tidak ditemukan"], 404);
    }


}
