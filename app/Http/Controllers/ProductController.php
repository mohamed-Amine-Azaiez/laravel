<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        $products = Product::with('SubCategory', 'ProductImage')->get();
        return response()->json([
            'products' => $products
        ], 200);
    }
    public function image($fileName)
    {
        $path = public_path() . "/gallery_products/" . $fileName;

        return Response::download($path);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $userAuth = auth('api')->user();
        if ($userAuth && $userAuth->role == 3) {
            $validator = Validator::make($request->all(), [
                'name' => 'required|min:4|unique:products', 'unique:ref', 'description' => 'required', 'price' => 'required', 'sub_category_id' => 'required', 'quantity' => 'required'/* , 'picture' => 'mimes: jpeg,jpg,png,gif|max:10000' */
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'message' => $validator->errors()
                ], 500);
            }
            $input = $request->all();

            $product = Product::create(array_merge($input, ['provider_id' => $userAuth->id]));
            $allowedfileExtension = ['pdf', 'jpg', 'png'];
            $files = $request->file('picture');

            $errors = [];
            if ($request->picture <> []) {
                //   foreach ($files as $file) {

                // $extension = $file->getClientOriginalExtension();

                // $check = in_array($extension, $allowedfileExtension);

                //   if ($check) {
                // foreach ($request['picture'] as $mediaFiles) {

                /* $path = $mediaFiles->store('public/gallery_products/');
                            $name = $mediaFiles->getClientOriginalName(); */
                $mediaFiles = $request->picture[0];
                $rr = sprintf("%06d", mt_rand(1, 999999));
                $destinationPath = 'gallery_products/';
                $imageName = $rr . date('ymdhis') . "." . $mediaFiles->getClientOriginalExtension();
                $mediaFiles->move($destinationPath, $imageName);

                //store image file into directory and db
                $save = new ProductImage();
                $save->product_id = $product->id;
                $save->picture = $imageName;
                $save->save();
                // }
                /*  } else {
                        return response()->json(['invalid_file_format'], 422);
                    } */
                // }
            }


            return response()->json([
                'message' => 'product created',
                'status_code' => 201,
                'data' => $product
            ], 201);
        } else {
            return response()->json([
                'message' => 'unauthorized'
            ], 401);
        }

        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
        return response()->json([
            'product' => $product
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {

        $userAuth = auth('api')->user();
        if ($userAuth && $userAuth->role == 3) {
            $input = $request->all();
            if ($picture = $request->file('picture')) {
                $destinationPath = 'gallery_products/';
                $imageName = date('ymdhis') . "." . $picture->getClientOriginalExtension();
                $picture->move($destinationPath, $imageName);
                $input['picture'] = $imageName;
            }

            $product->update($input);

            return response()->json([
                'message' => 'product updated',
                'status_code' => 201,
                'data' => $product
            ], 201);
        } else {
            return response()->json([
                'message' => 'unauthorized'
            ], 401);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $userAuth = auth('api')->user();
        if ($userAuth && $userAuth->role == 3) {
            $product->delete();

            return response()->json([
                'message' => 'product deleted',
                'status_code' => 200,
            ], 201);
        } else {
            return response()->json([
                'message' => 'unauthorized'
            ], 401);
        }
    }
    public function getByCategoryId($id)
    {
        //
        $product = Product::where('sub_category_id', "=", $id)->get();
        return response()->json([
            'product' => $product
        ], 200);
    }
}
