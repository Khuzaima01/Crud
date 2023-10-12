<?php

namespace App\Http\Controllers;

use App\Models\product_images;
use App\Models\products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class products_controller extends Controller
{
    public function create_product(Request $request)
    {
        $product = products::create([
            'name' => $request->name,
            'price' => $request->price,
        ]);

        $product_image = new product_images();

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $image_name = $image->getClientOriginalName();
            $image->move(public_path('images'), $image_name);
            $image_path = 'images/' . $image_name;
            $product_image->product_id = $product->id;
            $product_image->img_path = $image_name;
            $product_image->save();
        }
        return redirect()->back();
    }

    public function show(){
        $product =  DB::table('products')
        ->join('product_images', 'products.id' , '=' , 'product_images.product_id')
        ->get();

        return view('show', compact('product'));
    }


    public function delete(Request $request, $id){
        return $id;
    }
}
