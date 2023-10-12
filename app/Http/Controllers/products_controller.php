<?php

namespace App\Http\Controllers;

use App\Models\product_images;
use App\Models\products;
use Faker\Core\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File as FacadesFile;
use Illuminate\Support\Facades\Validator;

use function PHPUnit\Framework\fileExists;

class products_controller extends Controller
{
    public function create_product(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'price' => 'required',
            'image' => 'required',
        ]);

        if ($validator->passes()) {
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
            return redirect()->route('show_products')->with([
                'product_created_succ' => 'Product created Successfully',
            ]);
        } else {
            return redirect()->back()->withErrors($validator->errors());
        }
    }

    public function show()
    {
        $product =  DB::table('product_images')
            ->join('products', 'products.id', '=', 'product_images.product_id')
            ->get();

        return view('show', compact('product'));
    }

    public function edit_product($id)
    {
        $product = DB::table('product_images')
            ->where('product_id', $id)
            ->join('products', 'products.id', '=', 'product_images.product_id')
            ->select('products.id', 'products.name', 'products.price', 'product_images.img_path')
            ->first(); // Use first() to retrieve a single result

        return view('edit', compact('product'));
    }

    public function update_product(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'price' => 'required',
        ]);

        if ($validator->passes()) {
            $product = products::find($id);
            $product->name = $request->name;
            $product->price = $request->price;
            $product->save();
            
            $old_img = product_images::where('product_id', $id)->first();
            $old_img_path = public_path('images/' . $old_img->img_path);
            
            if ($request->hasFile('image')) {
                FacadesFile::delete($old_img_path);
                
                $image = $request->file('image');
                $image_name = $image->getClientOriginalName();
                $image_path = 'images/' . $image_name;
                
                $old_img->img_path = $image_name;
                $old_img->save();
                $image->move(public_path('images'), $image_name);
            }
            return redirect()->route('show_products')->with([
                'product_updated_succ' => 'Product updated Successfully',
            ]);
        } else {
            return redirect()->back()->withErrors($validator->errors());
        }
    }

    public function delete(Request $request, $id)
    {
        $product_image = product_images::where('product_id', $id)->first();
        $product = products::where('id', $id)->first();
        $product_img_path = public_path('images/' . $product_image->img_path);

        if (fileExists($product_img_path)) {
            $product_image->delete();
            $product->delete();
            FacadesFile::delete($product_img_path);
        } else {
            return redirect()->back()->with([
                'img_!found_err' => 'Oops Image not found',
            ]);
        }

        return redirect()->route('show_products')->with([
            'delete_message' => 'Product deleted Successfully',
        ]);
    }
}
