<?php

namespace App\Http\Controllers;

use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subCategories = SubCategory::with('category')->get();
        return response()->json([
            'subCategories' => $subCategories
        ], 200);
        //
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
        //
        $userAuth = auth('api')->user();
        if ($userAuth && $userAuth->role == 1) {
            $validator = Validator::make($request->all(), [
                'name' => 'required|min:4|unique:categories', 'description' => 'required', 'category_id' => 'required'
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'message' => $validator->errors()
                ], 500);
            }

            $subCategory = SubCategory::create($request->all());

            return response()->json([
                'message' => 'Sub category created',
                'status_code' => 201,
                'data' => $subCategory
            ], 201);
        } else {
            return response()->json([
                'message' => 'unauthorized'
            ], 401);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SubCategory  $subCategory
     * @return \Illuminate\Http\Response
     */
    public function show(SubCategory $subCategory)
    {
        //
        return response()->json([
            'subCategory' => $subCategory
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SubCategory  $subCategory
     * @return \Illuminate\Http\Response
     */
    public function edit(SubCategory $subCategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SubCategory  $subCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SubCategory $subCategory)
    {
        //
        $userAuth = auth('api')->user();
        if ($userAuth && $userAuth->role == 1) {
            $validator = Validator::make($request->all(), [
                'name' => 'min:4|unique:categories',
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'message' => $validator->errors()
                ], 500);
            }
            $subCategory->update($request->all());

            return response()->json([
                'message' => 'subCategory updated',
                'status_code' => 200,
                'data' => $subCategory
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
     * @param  \App\Models\SubCategory  $subCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(SubCategory $subCategory)
    {
        //
        $userAuth = auth('api')->user();
        if ($userAuth && $userAuth->role == 1) {
            $subCategory->delete();

            return response()->json([
                'message' => 'subCategory deleted',
                'status_code' => 200,
            ], 201);
        } else {
            return response()->json([
                'message' => 'unauthorized'
            ], 401);
        }
    }
}
