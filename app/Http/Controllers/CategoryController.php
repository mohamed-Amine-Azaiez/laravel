<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $categories = Category::get();
        return response()->json([
            'categories' => $categories
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
        if ($userAuth && $userAuth->role == 1) {
            $validator = Validator::make($request->all(), [
                'name' => 'required|min:4|unique:categories', 'description' => 'required'
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'message' => $validator->errors()
                ], 500);
            }

            $category = Category::create($request->all());

            return response()->json([
                'message' => 'category created',
                'status_code' => 201,
                'data' => $category
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
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //

        return response()->json([
            'category' => $category
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {

        $userAuth = auth('api')->user();
        if ($userAuth && $userAuth->role == 1) {
            if ($category->name <> $request->name) {
                $validator = Validator::make($request->all(), [
                    'name' => 'min:4|unique:categories',
                ]);
                if ($validator->fails()) {
                    return response()->json([
                        'message' => $validator->errors()
                    ], 500);
                }
            }

            $category->update($request->all());

            return response()->json([
                'message' => 'category updates',
                'status_code' => 200,
                'data' => $category
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
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $userAuth = auth('api')->user();
        if ($userAuth && $userAuth->role == 1) {
            $category->delete();

            return response()->json([
                'message' => 'category deleted',
                'status_code' => 200,
            ], 201);
        } else {
            return response()->json([
                'message' => 'unauthorized'
            ], 401);
        }
    }
}
