<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use GuzzleHttp\Handler\Proxy;

class ProductController extends Controller
{
    function addProduct(Request $req){
        $validator=validator($req->all(),[
            "name" => "required",
            "price" => "required",    
            "file"=>'required|file|mimes:jpeg,png,jpg,gif,svg,pdf,doc,docx,txt',
        ]);
        if($validator->fails()){
            $error=$validator->errors();
            return response()->json([
                "status" => "error",
                "error"  => $error->all(),
            ]);
        }
        $file_path=$req->file("file")->store("products");
        
        $product=new Product();
        $product->name=$req->input("name");
        $product->price=$req->input("price");
        $product->description=$req->input("description");
        $product->file_name=$req->file("file")->getClientOriginalName();
        $product->file_path=$file_path;
        $product->save();
        return response()->json([
            "success" => true,
            "data"    => $product,
        ]);
    }
    function list(){
        return Product::all();
    }
    function productId($id){
        return Product::find($id);
    }
    function delete($id){
        $result= Product::where("id",$id)->delete();
        if($result){
            return ["result"=>"product has been delete"];
        }else{
            return ["result"=>"Operation fail"];
        }
    }
    function update(Request $req,$id){
        $validator=validator($req->all(),[
            "name" => "required",
            "price" => "required",    
            "file"=>'required|file|mimes:jpeg,png,jpg,gif,svg,pdf,doc,docx,txt',
        ]);
        if($validator->fails()){
            $error=$validator->errors();
            return response()->json([
                "status" => "error",
                "error"  => $error->all(),
            ]);
        }
        $file_path=$req->file("file")->store("products");
        $result=Product::find($id);
        $result->name=$req->input("name");
        $result->price=$req->input("price");
        $result->description=$req->input("description");
        $result->file_name=$req->file("file")->getClientOriginalName();
        $result->file_path=$file_path;
        $result->save();
        return response()->json([
            "success" => true,
            "data"    => $result,
        ]);

    }
}
