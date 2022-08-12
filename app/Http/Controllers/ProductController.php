<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
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
        $products = Product::with('SubCategory')->get();
        return response()->json([
            'products' => $products
        ], 200);
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
            if ($picture = $request->file('picture')) {
                $destinationPath = 'gallery_products/';
                $imageName = date('ymdhis') . "." . $picture->getClientOriginalExtension();
                $picture->move($destinationPath, $imageName);
                $input['picture'] = "aaa.jpg"; //$imageName;
            }

            $product = Product::create(array_merge($input, ['provider_id' => $userAuth->id]));

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
